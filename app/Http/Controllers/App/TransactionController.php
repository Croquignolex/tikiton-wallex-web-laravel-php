<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TransactionFilterRequest;

class TransactionController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $transactions = null; $begin_date = null; $end_date = null;

        if(session()->has('begin_date') && session()->has('end_date'))
        {
            $begin_date = session('begin_date');
            $end_date = session('end_date');
        }
        else
        {
            $begin_date = Carbon::now()->startOfDay();
            $end_date = Carbon::now()->endOfDay();
        }

        try
        {
            $transactions = Auth::user()->transactions
                ->where('created_at', '>=', $begin_date)
                ->where('created_at', '<=',$end_date)
                ->sortByDesc('created_at')
                ->load('category', 'wallets');
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('app.transactions.index', compact('transactions',
            'begin_date', 'end_date'));
    }

    /**
     * @param TransactionFilterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(TransactionFilterRequest $request)
    {
        $transactions = null; $begin_date = null; $end_date = null;
        try
        {
            session()->flash('begin_date', $this->carbonFormatDate($request->input('begin_date')));
            session()->flash('end_date', $this->carbonFormatDate($request->input('end_date')));
        }
        catch (Exception $exception)
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }

        return redirect($this->redirectTo());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        if(!$this->isType(Hash::make($type)))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back();
        }
        try
        {
            $categories = Auth::user()->categories->where('type', $type)->sortByDesc('update_at');
            $wallets = Auth::user()->wallets->sortByDesc('update_at')->load('currency');
            return view('app.transactions.create', compact('type', 'categories', 'wallets'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param $language
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function walletCreate(Request $request, $language, Wallet $wallet)
    {
        $type = $request->query('type');
        if(!$this->isType(Hash::make($type)))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back();
        }
        try
        {
            $categories = Auth::user()->categories->where('type', $type)->sortByDesc('update_at');
            $wallets = Auth::user()->wallets->sortByDesc('update_at')->load('currency');
            if($wallet->authorised)  return view('app.wallets.transaction', compact('type', 'categories', 'wallets', 'wallet'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $type = $request->input('token');
        $amount = $request->input('transaction_amount');
        $date = $request->input('date');
        if(!$this->isType($type))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }

        try
        {
            if(Hash::check(Category::TRANSFER, $type))
            {
                $debit_wallet_id = intval($request->input('debit_account'));
                $credit_account_id = intval($request->input('credit_account'));
                $category = Category::where('id', intval($request->input('category')))->first();
                $debit_wallet = Wallet::where('id', $debit_wallet_id)->first();
                $credit_wallet = Wallet::where('id', $credit_account_id)->first();
                if($category->authorised && $debit_wallet->authorised && $credit_wallet->authorised)
                {
                    if($debit_wallet->currency->id === $credit_wallet->currency->id)
                    {
                        //Update accounts
                        if($debit_wallet->balance >= $amount)
                        {
                            if($debit_wallet_id !== $credit_account_id)
                            {
                                $debit_wallet->update(['balance' =>  $debit_wallet->balance - $amount]);
                                $credit_wallet->update(['balance' =>  $credit_wallet->balance + $amount]);
                            }
                        }
                        else
                        {
                            danger_flash_message(trans('auth.error'),
                                trans('general.debit_account_balance_is_smaller', ['name' => $debit_wallet->name]));
                            return back()->withInput($request->all());
                        }

                        //save
                        $transaction = Auth::user()->transactions()->create([
                            'name' => $request->input('name'),
                            'description' => $request->input('description'),
                            'amount' => $amount,
                            'category_id' => $category->id,
                            'created_at' => $this->carbonFormatDate($date)
                        ]);

                        $debit_wallet->transactions()->save($transaction);
                        $credit_wallet->transactions()->save($transaction);
                    }
                    else
                    {
                        danger_flash_message(trans('auth.error'),
                            trans('general.not_the_same_currency'));
                        return back()->withInput($request->all());
                    }
                }
                else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            }
            else
            {
                //Fetch account and category
                if(Hash::check(Category::INCOME, $type)) $category = Category::where('id', intval($request->input('category')))->where('type', Category::INCOME)->first();
                else $category = Category::where('id', intval($request->input('category')))->where('type', Category::EXPENSE)->first();

                $wallet = Wallet::where('id', intval($request->input('account')))->first();
                if($category->authorised && $wallet->authorised)
                {
                    //Update accounts
                    if(Hash::check(Category::INCOME, $type)) $wallet->update(['balance' =>  $wallet->balance + $amount]);
                    else
                    {
                        if($wallet->balance >= $amount) $wallet->update(['balance' =>  $wallet->balance - $amount]);
                        else
                        {
                            danger_flash_message(trans('auth.error'),
                                trans('general.account_balance_is_smaller', ['name' => $wallet->name]));

                            return back()->withInput($request->all());
                        }
                    }

                    //Save
                    $wallet->transactions()->create([
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'amount' => $amount,
                        'category_id' => $category->id,
                        'created_at' => $this->carbonFormatDate($date)
                    ]);
                }
                else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            }

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $request->input('name')]));

            return redirect($this->redirectTo());
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back()->withInput($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @param $language
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function walletStore(TransactionRequest $request, $language, Wallet $wallet)
    {
        $type = $request->input('token');
        $amount = $request->input('transaction_amount');
        $date = $request->input('date');
        if(!$this->isType($type))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }

        try
        {
            if(Hash::check(Category::TRANSFER, $type))
            {
                $credit_account_id = intval($request->input('credit_account'));
                $category = Category::where('id', intval($request->input('category')))->first();
                $credit_wallet = Wallet::where('id', $credit_account_id)->first();
                if($category->authorised && $wallet->authorised && $credit_wallet->authorised)
                {
                    if($wallet->currency->id === $credit_wallet->currency->id)
                    {
                        //Update accounts
                        if($wallet->balance >= $amount)
                        {
                            if($wallet->id !== $credit_account_id)
                            {
                                $wallet->update(['balance' =>  $wallet->balance - $amount]);
                                $credit_wallet->update(['balance' =>  $credit_wallet->balance + $amount]);
                            }
                        }
                        else
                        {
                            danger_flash_message(trans('auth.error'),
                                trans('general.debit_account_balance_is_smaller', ['name' => $wallet->name]));
                            return back()->withInput($request->all());
                        }

                        //save
                        $transaction = Auth::user()->transactions()->create([
                            'name' => $request->input('name'),
                            'description' => $request->input('description'),
                            'amount' => $amount,
                            'category_id' => $category->id,
                            'created_at' => $this->carbonFormatDate($date)
                        ]);

                        $wallet->transactions()->save($transaction);
                        $credit_wallet->transactions()->save($transaction);
                    }
                    else
                    {
                        danger_flash_message(trans('auth.error'),
                            trans('general.not_the_same_currency'));
                        return back()->withInput($request->all());
                    }
                }
                else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            }
            else
            {
                //Fetch account and category
                if(Hash::check(Category::INCOME, $type)) $category = Category::where('id', intval($request->input('category')))->where('type', Category::INCOME)->first();
                else $category = Category::where('id', intval($request->input('category')))->where('type', Category::EXPENSE)->first();

                if($category->authorised && $wallet->authorised)
                {
                    //Update accounts
                    if(Hash::check(Category::INCOME, $type)) $wallet->update(['balance' =>  $wallet->balance + $amount]);
                    else
                    {
                        if($wallet->balance >= $amount) $wallet->update(['balance' =>  $wallet->balance - $amount]);
                        else
                        {
                            danger_flash_message(trans('auth.error'),
                                trans('general.account_balance_is_smaller', ['name' => $wallet->name]));

                            return back()->withInput($request->all());
                        }
                    }

                    //Save
                    $wallet->transactions()->create([
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'amount' => $amount,
                        'category_id' => $category->id,
                        'created_at' => $this->carbonFormatDate($date)
                    ]);
                }
                else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            }

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $request->input('name')]));

            return redirect(locale_route('wallets.show', [$wallet]));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back()->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $language
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, Transaction $transaction)
    {
        try
        {
            $transaction->load('wallets', 'category');
            if($transaction->authorised) return view('app.transactions.show', compact('transaction'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $language
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $language, Transaction $transaction)
    {
        try
        {
            $transaction->load('wallets', 'category');
            if($transaction->authorised) return view('app.transactions.edit', compact('transaction'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionUpdateRequest $request
     * @param $language
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionUpdateRequest $request, $language, Transaction $transaction)
    {
        try
        {
            if($transaction->authorised)
            {
                $transaction->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'created_at' => $this->carbonFormatDate($request->input('date'))
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.update_successful', ['name' => $request->input('name')]));

                return redirect(locale_route('transactions.show', [$transaction]));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));

        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $language
     * @param Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $language, Transaction $transaction)
    {
        try
        {
            if($transaction->authorised)
            {
                if($transaction->can_be_deleted)
                {
                    if($transaction->is_an_income) $transaction->wallet->update(['balance' => $transaction->wallet->balance - $transaction->amount]);
                    else if($transaction->is_an_expense) $transaction->wallet->update(['balance' => $transaction->wallet->balance + $transaction->amount]);
                    else
                    {
                        if($transaction->wallet->id !== $transaction->transfer_wallet->id)
                        {
                            $transaction->transfer_wallet->update(['balance' => $transaction->transfer_wallet->balance - $transaction->amount]);
                            $transaction->wallet->update(['balance' => $transaction->wallet->balance + $transaction->amount]);
                        }
                    }
                    $transaction->delete();
                    info_flash_message(trans('auth.info'),
                        trans('general.delete_successful', ['name' => $transaction->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_transaction'));

            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->redirectTo());
    }

    /**
     * @param $type
     * @return bool
     */
    private function isType($type)
    {
        if(Hash::check(Category::EXPENSE, $type) ||
            Hash::check(Category::TRANSFER, $type) ||
            Hash::check(Category::INCOME, $type)) return true;

        return false;
    }

    /**
     * @return bool
     */
    private function redirectTo()
    {
        return locale_route('transactions.index') ;
    }

    /**
     * @param $date
     * @return Carbon
     */
    private function carbonFormatDate($date)
    {
        $locale = App::getLocale();
        if($locale === 'en')
            return Carbon::createFromFormat('m/d/Y h:i A', $date);
        else if($locale === 'fr')
            return Carbon::createFromFormat('d/m/Y H:i', $date);

        return Carbon::now();
    }
}