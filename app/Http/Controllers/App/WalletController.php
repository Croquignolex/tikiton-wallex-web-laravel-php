<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\PaginationTrait;
use App\Traits\LocaleAmountTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Traits\ErrorFlashMessagesTrait;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\TransactionFilterRequest;

class WalletController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $wallets = collect();
        try
        {
            $wallets = Auth::user()->wallets()->get()
                ->sortByDesc('updated_at')->load('currency');
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        $this->paginate($request, $wallets, 6, 3);
        $paginationTools = $this->paginationTools;

        return view('app.wallets.index', compact('paginationTools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Auth::user()->currencies->sortByDesc('updated_at');
        return view('app.wallets.create', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param $language
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function currencyCreate(Request $request, $language, Currency $currency)
    {
        try
        {
            if($currency->authorised) return view('app.currencies.wallet', compact('currency'));
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
     * @param WalletRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletRequest $request)
    {
        $name = $request->input('name');
        $this->walletExist($name);

        try
        {
            $currency = Currency::where('id', intval($request->input('currency')))->first();
            if($currency->authorised)
            {
                $wallet = Auth::user()->wallets()->create([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'is_stated' => $request->input('stated') == null ? false : true,
                    'balance' => doubleval($request->input('balance')) * $currency->devaluation,
                    'threshold' =>  doubleval($request->input('threshold'))  * $currency->devaluation,
                    'color' => $request->input('color'),
                    'currency_id' => $currency->id
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.add_successful', ['name' => $name]));

                return redirect($this->showRoute($wallet));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
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
     * @param WalletRequest $request
     * @param $language
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function currencyStore(WalletRequest $request, $language, Currency $currency)
    {
        $name = $request->input('name');
        $this->walletExist($name);

        try
        {
            if($currency->authorised)
            {
                Auth::user()->wallets()->create([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'is_stated' => $request->input('stated') == null ? false : true,
                    'balance' => doubleval($request->input('balance')) * $currency->devaluation,
                    'threshold' => doubleval($request->input('threshold')) * $currency->devaluation,
                    'color' => $request->input('color'),
                    'currency_id' => $currency->id
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.add_successful', ['name' => $name]));

                return redirect(locale_route('currencies.show', [$currency]));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
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
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, Wallet $wallet)
    {
        $tab = $request->query('tab');
        $begin_date = Carbon::now()->startOfDay(); $end_date = Carbon::now()->endOfDay();

        if(session()->has('begin_date') && session()->has('end_date'))
        {
            $begin_date = session('begin_date');
            $end_date = session('end_date');
        }
        try
        {
            $transactions = $wallet->transactions
                ->where('created_at', '>=', $begin_date)->where('created_at', '<=',$end_date)
                ->sortByDesc('created_at')->load('category', 'wallets');

            $incomesPercent = $this->getTransactionTypePercentage($transactions, Category::INCOME);
            $transfersPercent = $this->getTransactionTypePercentage($transactions, Category::TRANSFER);
            $expensesPercent = $this->getTransactionTypePercentage($transactions, Category::EXPENSE);

            $wallet->load('transactions', 'currency');
            if($wallet->authorised) return view('app.wallets.show', compact('wallet', 'transactions',
                'begin_date', 'end_date', 'tab', 'incomesPercent', 'transfersPercent', 'expensesPercent'));
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {

            $this->databaseError($exception);
        }

        return back();
    }

    /**
     * @param TransactionFilterRequest $request
     * @param $language
     * @param Wallet $wallet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter(TransactionFilterRequest $request, $language, Wallet $wallet)
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

        return redirect(locale_route('wallets.show', [$wallet]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param $language
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $language, Wallet $wallet)
    {
        try
        {
            if($wallet->authorised)
            {
                $currencies = Auth::user()->currencies->sortByDesc('updated_at');
                return view('app.wallets.edit', compact('wallet', 'currencies'));
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
     * Update the specified resource in storage.
     *
     * @param WalletRequest $request
     * @param $language
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(WalletRequest $request, $language, Wallet $wallet)
    {
        $name = $request->input('name');
        $this->walletExist($name, $wallet->id);

        try
        {
            $currency = Currency::where('id', intval($request->input('currency')))->first();
            if($currency->authorised && $wallet->authorised)
            {
                $wallet->update([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'is_stated' => $request->input('stated') == null ? false : true,
                    'balance' => doubleval($request->input('balance')) * $currency->devaluation,
                    'threshold' => doubleval($request->input('threshold')) * $currency->devaluation,
                    'color' => $request->input('color'),
                    'currency_id' => $currency->id
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.update_successful', ['name' => $name]));

                return redirect($this->showRoute($wallet, 'details'));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back()->withInput($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $language
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $language, Wallet $wallet)
    {
        try
        {
            if($wallet->authorised)
            {
                if($wallet->can_be_deleted)
                {
                    $wallet->delete();
                    info_flash_message(trans('auth.info'),
                        trans('general.delete_successful', ['name' => $wallet->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_account'));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('wallets.index'));
    }

    /**
     * @param Request $request
     * @param Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableStat(Request $request, $language, Wallet $wallet)
    {
        try
        {
            if($wallet->authorised)
            {
                $wallet->update(['is_stated' => false ]);
                info_flash_message(trans('auth.info'),
                    trans('general.disable_stat_successful', ['name' => $wallet->name]));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->showRoute($wallet, 'details'));
    }

    /**
     * @param Request $request
     * @param Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableStat(Request $request, $language, Wallet $wallet)
    {
        try
        {
            if($wallet->authorised)
            {
                $wallet->update(['is_stated' => true ]);
                info_flash_message(trans('auth.info'),
                    trans('general.enable_stat_successful', ['name' => $wallet->name]));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->showRoute($wallet, 'details'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report()
    {
        $wallets = collect(); $current_currency = null; $total = 0;
        try
        {
            $wallets = Auth::user()->wallets()->get()
                ->sortByDesc('updated_at')->load('currency');
            $current_currency = Auth::user()->currencies()
                ->where('is_current', true)->first();

            $total = $this->formatNumber(
                $wallets->where('is_stated', true)->sum(function (Wallet $wallet) {
                            return $wallet->balance;
            }) / $current_currency->devaluation);
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return view('app.reports.wallets', compact('wallets',
            'current_currency', 'total'));
    }

    /**
     * Check if the account already exist
     *
     * @param  string $name
     * @param int $id
     * @return void
     */
    private function walletExist($name, $id = 0)
    {
        if(Auth::user()->wallets->where('slug', Auth::user()->id . '-' . str_slug($name))
                ->where('id', '<>', $id)->count() > 0)
        {
            throw ValidationException::withMessages([
                'name' => trans('general.already_exist', ['name' => mb_strtolower($name)]),
            ])->status(423);
        }
    }

    /**
     * @param Wallet $wallet
     * @param $tab
     * @return bool
     */
    private function showRoute(Wallet $wallet, $tab = '')
    {
        return locale_route('wallets.show', [$wallet]) . '?tab=' . $tab;
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
}
