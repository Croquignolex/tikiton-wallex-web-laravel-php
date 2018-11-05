<?php

namespace App\Http\Controllers\App;

use Exception;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;

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

        return view('app.wallet.index', compact('paginationTools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccountRequest $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(AccountRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'amount' => $request->amount,
            'threshold' => $request->threshold,
            'stated' => $request->stated == null ? false : true,
            'currency_id' => $request->currency
        ];

        $this->accountExist($request->name);

        Auth::user()->accounts()->create($data);

        flash_message(
            __('general.success'), 'Compte ajouté avec succès',
            'success', 'fa fa-thumbs-up'
        );

        return redirect($this->redirectTo());
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $language
     * @param Account $account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, Account $account)
    {
        if($request->query('date') == null) $date_range = 0;
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
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $language
     * @param Account $account
     * @return \Illuminate\Http\Response
     */
    public function edit($language, Account $account)
    {
        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountRequest $request
     * @param $language
     * @param Account $account
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function update(AccountRequest $request, $language, Account $account)
    {
        $data = [
            'name' => strtolower($request->name),
            'description' => $request->description,
            'color' => $request->color,
            'amount' => $request->amount,
            'threshold' => $request->threshold,
            'stated' => $request->stated == null ? false : true,
            'currency_id' => $request->currency
        ];

        $this->accountExist($request->name, $account->id);

        $account->update($data);

        flash_message(
            __('general.success'), 'Compte modifié avec succès.',
            'success', 'fa fa-thumbs-up'
        );

        return redirect($this->redirectTo());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $language
     * @param Account $account
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($language, Account $account)
    {
        $account->delete();

        flash_message(
            'Information', 'Compte supprimé avec succès. '
        );

        return redirect($this->redirectTo());
    }

    /**
     * Check if the account already exist
     *
     * @param  string $name
     * @param int $account_id
     * @return void
     * @throws ValidationException
     */
    private function accountExist($name, $account_id = 0)
    {
        if(Auth::user()->accounts
                ->where('slug', str_slug($name))
                ->where('id', '<>', $account_id)
                ->count() > 0)
        {
            throw ValidationException::withMessages([
                'name' => 'Un compte existe déjà avec ce nom',
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
        return route_manager('accounts.index');
    }
}
