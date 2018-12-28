<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\PaginationTrait;
use App\Traits\LocaleAmountTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Http\Requests\TransactionFilterRequest;

class TransactionController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait, LocaleAmountTrait;

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
        $transactions = collect();
        $begin_date = now(session('timezone'))->startOfDay();
        $end_date = now(session('timezone'))->endOfDay();

        if(session()->has('begin_date') && session()->has('end_date'))
        {
            $begin_date = session('begin_date');
            $end_date = session('end_date');
        }

        try
        {
            $begin_date->setTimezone('UTC');
            $end_date->setTimezone('UTC');

            $transactions = Auth::user()->transactions
                ->where('created_at', '>=', $begin_date)->where('created_at', '<=', $end_date)
                ->sortByDesc('id')->sortByDesc('created_at')->load('category', 'wallets');

            $begin_date->setTimezone(session('timezone'));
            $end_date->setTimezone(session('timezone'));

            $incomesPercent = $this->getTransactionTypePercentage($transactions, Category::INCOME);
            $transfersPercent = $this->getTransactionTypePercentage($transactions, Category::TRANSFER);;
            $expensesPercent = $this->getTransactionTypePercentage($transactions, Category::EXPENSE);;
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('app.transactions.index', compact('transactions',
            'begin_date', 'end_date', 'incomesPercent', 'transfersPercent', 'expensesPercent'));
    }

    /**
     * @param TransactionFilterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(TransactionFilterRequest $request)
    {
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

        return redirect($this->indexRoute());
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
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param $language
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function categoryCreate(Request $request, $language, Category $category)
    {
        $type = $category->type;
        try
        {
            $wallets = Auth::user()->wallets->sortByDesc('update_at')->load('currency');
            if($category->authorised)  return view('app.categories.transaction', compact('type', 'category', 'wallets'));
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
        if(!$this->isType($type))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }
        try
        {
            $category = Category::where('id', intval($request->input('category')))->first();
            if(Hash::check(Category::TRANSFER, $type)) $wallet = Wallet::where('id', intval($request->input('debit_account')))->first();
            else $wallet = Wallet::where('id', intval($request->input('account')))->first();

            $response = $this->transactionStore($request, $type, $category, $wallet);
            if($response !== null) return redirect($this->indexRoute());
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
        if(!$this->isType($type))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }
        try
        {
            $category = Category::where('id', intval($request->input('category')))->first();
            $response = $this->transactionStore($request, $type, $category, $wallet);
            if($response !== null) return redirect(locale_route('wallets.show', [$wallet]));
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
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function categoryStore(TransactionRequest $request, $language, Category $category)
    {
        $type = Hash::make($category->type);
        if(!$this->isType($type))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back()->withInput($request->all());
        }
        try
        {
            if(Hash::check(Category::TRANSFER, $type)) $wallet = Wallet::where('id', intval($request->input('debit_account')))->first();
            else $wallet = Wallet::where('id', intval($request->input('account')))->first();

            $response = $this->transactionStore($request, $type, $category, $wallet);
            if($response !== null) return redirect(locale_route('categories.show', [$category]));
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
        $name = $request->input('name');
        $creation_date = $this->carbonFormatDate($request->input('date'));
        $creation_date->setTimezone('UTC');
        try
        {
            if($transaction->authorised)
            {
                $transaction->update([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'created_at' => $creation_date
                ]);

                success_flash_message(trans('auth.success'), trans('general.update_successful', ['name' => $name]));
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

        return redirect($this->indexRoute());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function incomeReport(Request $request)
    {
        return $this->report($request, Category::INCOME,
            'app.reports.incomes');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function transferReport(Request $request)
    {
        return $this->report($request, Category::TRANSFER,
            'app.reports.transfers');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function expenseReport(Request $request)
    {
        return $this->report($request, Category::EXPENSE,
            'app.reports.expenses');
    }

    /**
     * @param Request $request
     * @param $category_type
     * @param $view_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    private function report(Request $request, $category_type, $view_name)
    {
        if($request->query('date') == null) $date_range = 0;
        else $date_range = $request->query('date');
        $type = $request->query('type');

        $types = [Transaction::DAILY, Transaction::WEEKLY, Transaction::MONTHLY, Transaction::YEARLY];
        if(!(is_string($type) && in_array($type, $types)) || !is_numeric($date_range))
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return back();
        }

        $begin_date = now(session('timezone'));
        $end_date = now(session('timezone'));
        $current_currency = $this->getCurrency();

        if($type === Transaction::DAILY)
        {
            $begin_date->addDay($date_range)->startOfDay();
            $end_date->addDay($date_range)->endOfDay();
        }
        else if($type === Transaction::WEEKLY)
        {
            $begin_date->addWeek($date_range)->startOfWeek();
            $end_date->addWeek($date_range)->endOfWeek();
        }
        else if($type === Transaction::MONTHLY)
        {
            $begin_date->addMonth($date_range)->startOfMonth();
            $end_date->addMonth($date_range)->endOfMonth();
        }
        else
        {
            $begin_date->addYear($date_range)->startOfYear();
            $end_date->addYear($date_range)->endOfYear();
        }

        $begin_date->setTimezone('UTC');
        $end_date->setTimezone('UTC');

        $transactions = $this->filterTransactionPerCategoryType(
            Auth::user()->transactions
                ->where('created_at', '>=', $begin_date)
                ->where('created_at', '<=', $end_date)
                ->sortByDesc('created_at'), $category_type);

        $begin_date->setTimezone(session('timezone'));
        $end_date->setTimezone(session('timezone'));

        $total = $this->transactions_category_amount($transactions);
        return view($view_name, compact('transactions',
            'type', 'date_range', 'current_currency', 'total', 'begin_date',
            'end_date'));
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
    private function indexRoute()
    {
        return locale_route('transactions.index') ;
    }

    /**
     * @param $transactions
     * @param $type
     * @return float
     */
    private function getTransactionTypePercentage($transactions, $type)
    {
        try
        {
            $transactionsAmount = $transactions->sum(function (Transaction $transaction) {
                if($transaction->is_stated) return $transaction->amount;
                return 0;
            });
            $percentage = ($transactions->sum(function (Transaction $transaction) use ($type) {
                        if($transaction->category->type === $type && $transaction->is_stated) return $transaction->amount;
                        return 0;
                    }) * 100) / $transactionsAmount;
        }
        catch (Exception $exception)
        {
            $percentage = 0;
        }

        return round($percentage);
    }


    /**
     * @param Collection $transactions
     * @return string
     */
    private function transactions_category_amount(Collection $transactions)
    {
        $currency = $this->getCurrency();
        $transactions_amount = $transactions->sum(function (Transaction $transaction) {
                if($transaction->is_stated) return $transaction->amount;
                return 0;
            }) / $currency->devaluation;
        return $this->formatNumber($transactions_amount);
    }

    /**
     *
     */
    protected function getCurrency()
    {
        return Auth::user()->currencies
            ->where('is_current', true)->first();
    }

    /**
     * @param Collection $transactions
     * @param $category_type
     * @return Collection
     */
    private function filterTransactionPerCategoryType(Collection $transactions, $category_type)
    {
        return $transactions->filter(function (Transaction $transaction) use ($category_type) {
            if($transaction->category->type === $category_type) return true;
            return false;
        });
    }

    /**
     * @param Request $request
     * @param $type
     * @param Category $category
     * @param Wallet $wallet
     * @return Wallet|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse|null
     */
    private function transactionStore(Request $request, $type, Category $category, Wallet $wallet)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $creation_date = $this->carbonFormatDate($request->input('date'));
        $creation_date->setTimezone('UTC');

        if(Hash::check(Category::TRANSFER, $type)) return $this->transferTransactionStore($request, $name, $description, $creation_date, $category, $wallet);
        else
        {
            $amount = doubleval($request->input('transaction_amount')) * $wallet->currency->devaluation;
            if(Hash::check(Category::INCOME, $type)) return $this->incomeTransactionStore($name, $description, $amount, $creation_date, $category, $wallet);
            else return $this->expenseTransactionStore($name, $description, $amount, $creation_date, $category, $wallet);
        }
    }

    /**
     * @param Request $request
     * @param $name
     * @param $description
     * @param $creation_date
     * @param Category $category
     * @param Wallet $wallet
     * @return Wallet|\Illuminate\Http\RedirectResponse
     */
    private function transferTransactionStore(Request $request, $name, $description, Carbon $creation_date, Category $category, Wallet $wallet)
    {
        $transaction = null;
        $debit_wallet = $wallet;
        $credit_wallet_id = intval($request->input('credit_account'));
        $credit_wallet = Wallet::where('id', $credit_wallet_id)->first();
        $amount = doubleval($request->input('transaction_amount')) * $debit_wallet->currency->devaluation;

        if($category->authorised && $debit_wallet->authorised && $credit_wallet->authorised)
        {
            if($debit_wallet->currency->id === $credit_wallet->currency->id)
            {
                //Update accounts
                if($debit_wallet->balance >= $amount)
                {
                    if($debit_wallet->id !== $credit_wallet->id)
                    {
                        $debit_wallet->update(['balance' =>  $debit_wallet->balance - $amount]);
                        $credit_wallet->update(['balance' =>  $credit_wallet->balance + $amount]);
                    }
                    else
                    {
                        danger_flash_message(trans('auth.error'), trans('general.accounts_should_be_different'));
                        return null;
                    }
                }
                else
                {
                    danger_flash_message(trans('auth.error'), trans('general.debit_account_balance_is_smaller', ['name' => $debit_wallet->name]));
                    return null;
                }

                //save
                $transaction = Auth::user()->transactions()->create([
                    'name' => $name,
                    'description' => $description,
                    'amount' => $amount,
                    'category_id' => $category->id,
                    'currency_id' => $debit_wallet->currency->id,
                    'created_at' => $creation_date
                ]);

                $debit_wallet->transactions()->save($transaction);
                $credit_wallet->transactions()->save($transaction);
            }
            else
            {
                danger_flash_message(trans('auth.error'), trans('general.not_the_same_currency'));
                return null;
            }
        }
        else
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return null;
        }
        success_flash_message(trans('auth.success'), trans('general.add_successful', ['name' => $name]));

        return $transaction;
    }

    /**
     * @param $name
     * @param $description
     * @param Carbon $creation_date
     * @param $amount
     * @param Category $category
     * @param Wallet $wallet
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private function incomeTransactionStore($name, $description, $amount, Carbon $creation_date, Category $category, Wallet $wallet)
    {
        $transaction = null;
        if($category->authorised && $wallet->authorised)
        {
            //Update accounts
            $wallet->update(['balance' =>  $wallet->balance + $amount]);
            //Save
            $transaction = $wallet->transactions()->create([
                'name' => $name,
                'description' => $description,
                'amount' => $amount,
                'category_id' => $category->id,
                'currency_id' => $wallet->currency->id,
                'created_at' => $creation_date
            ]);
        }
        else
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return null;
        }
        success_flash_message(trans('auth.success'), trans('general.add_successful', ['name' => $name]));

        return $transaction;
    }

    /**
     * @param $name
     * @param $description
     * @param Carbon $creation_date
     * @param $amount
     * @param Category $category
     * @param Wallet $wallet
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function expenseTransactionStore($name, $description, $amount, Carbon $creation_date, Category $category, Wallet $wallet)
    {
        $transaction = null;
        if($category->authorised && $wallet->authorised)
        {
            if($wallet->balance >= $amount) $wallet->update(['balance' =>  $wallet->balance - $amount]);
            else
            {
                danger_flash_message(trans('auth.error'), trans('general.account_balance_is_smaller', ['name' => $wallet->name]));
                return null;
            }
            //Save
            $transaction = $wallet->transactions()->create([
                'name' => $name,
                'description' => $description,
                'amount' => $amount,
                'category_id' => $category->id,
                'currency_id' => $wallet->currency->id,
                'created_at' => $creation_date
            ]);
        }
        else
        {
            warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
            return null;
        }
        success_flash_message(trans('auth.success'), trans('general.add_successful', ['name' => $name]));

        return $transaction;
    }
}
