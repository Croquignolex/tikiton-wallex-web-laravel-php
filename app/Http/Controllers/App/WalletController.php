<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Traits\ErrorFlashMessagesTrait;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $wallets = null;

        try
        {
            $wallets = Auth::user()->wallets->sortByDesc('updated_at');
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
        return view('app.wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WalletRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletRequest $request)
    {
        $this->walletExist($request->input('name'));

        try
        {
            $wallet = Auth::user()->wallets()->create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'is_stated' => $request->input('stated') == null ? false : true,
                'balance' => $request->input('balance'),
                'threshold' => $request->input('threshold'),
                'color' => $request->input('color')
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $request->input('name')]));

            return redirect(locale_route('wallets.show', [$wallet]));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->redirectTo());
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
        try
        {
            if($wallet->authorised)
                return view('app.wallets.show', compact('wallet'));
            else
                warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back();

        /*if($request->query('date') == null) $date_range = 0;
        else $date_range = $request->query('date');

        if(!is_numeric($date_range)) return back();

        $date = Carbon::now();

        $transactions = Transaction::where('transfer_account_id', $account->id)
            ->orwhere('account_id', $account->id)
            ->get();

        $transactions = $transactions
            ->where('created_at', '>=', $date->addMonth($date_range)->startOfMonth())
            ->where('created_at', '<=', $date->addMonth($date_range)->endOfMonth())
            ->sortByDesc('created_at');

        $expensesNumber = $transactions->where('type', Group::EXPENSE)->count();
        $transfersNumber = $transactions->where('type', Group::TRANSFER)->count();
        $incomesNumber = $transactions->where('type', Group::INCOME)->count();

        return view('accounts.show', [
            'transactions' => $transactions,
            'date_range' => $date_range,
            'account' => $account,
            'expenses' => $expensesNumber,
            'transfers' => $transfersNumber,
            'incomes' => $incomesNumber
        ]);*/
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
                return view('app.wallets.edit', compact('wallet'));
            else
                warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
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
        $this->walletExist($request->input('name'), $wallet->id);

        try
        {
            $wallet->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'is_stated' => $request->input('stated') == null ? false : true,
                'balance' => $request->input('balance'),
                'threshold' => $request->input('threshold'),
                'color' => $request->input('color')
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.update_successful', ['name' => $request->input('name')]));

            return redirect(locale_route('wallets.show', [$wallet]));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->redirectTo());
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
                if($wallet->can_delete)
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

        return redirect($this->redirectTo());
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
                $wallet->is_stated = false;
                $wallet->save();
                info_flash_message(trans('auth.info'),
                    trans('general.disable_stat_successful', ['name' => $wallet->name]));
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
                $wallet->is_stated = true;
                $wallet->save();
                info_flash_message(trans('auth.info'),
                    trans('general.enable_stat_successful', ['name' => $wallet->name]));
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
     * Give the redirection path
     *
     * @return Router
     */
    private function redirectTo()
    {
        return locale_route('wallets.index');
    }
}
