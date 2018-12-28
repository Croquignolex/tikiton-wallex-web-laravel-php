<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Traits\ErrorFlashMessagesTrait;
use Illuminate\Validation\ValidationException;

class CurrencyController extends Controller
{
    use ErrorFlashMessagesTrait, PaginationTrait;

    /**
     * CurrencyController constructor.
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
        $currencies = collect();
        try
        {
            $currencies = Auth::user()->currencies
                ->sortByDesc('updated_at')->sortByDesc('is_current');
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        $this->paginate($request, $currencies, 10, 3);
        $paginationTools = $this->paginationTools;

        return view('app.currencies.index', compact('paginationTools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CurrencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request)
    {
        $name = $request->input('name');
        $symbol = $request->input('symbol');
        $current = $request->input('current');
        $this->currencyExist($name);
        $this->symbolExist($symbol);

        try
        {
            if($current != null) $this->toggleCurrentCurrency();

            $currency = Auth::user()->currencies()->create([
                'name' => $name,
                'description' => $request->input('description'),
                'symbol' =>  mb_strtoupper($symbol),
                'devaluation' => $request->input('devaluation'),
                'is_current' => $current == null ? false : true
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $name]));

            return redirect($this->showRoute($currency));
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
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, Currency $currency)
    {
        $tab = $request->query('tab');
        $currency->load('wallets');
        try
        {
            $currency->load('wallets');
            $wallets = $currency->wallets->sortByDesc('updated_at');
            if($currency->authorised) return view('app.currencies.show', compact('currency',
                'tab', 'wallets'));
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
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $language, Currency $currency)
    {
        try
        {
            if($currency->authorised) return view('app.currencies.edit', compact('currency'));
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
     * @param CurrencyRequest $request
     * @param $language
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, $language, Currency $currency)
    {
        $name = $request->input('name');
        $symbol = $request->input('symbol');
        $this->currencyExist($name, $currency->id);
        $this->symbolExist($symbol, $currency->id);
        $current = false;

        try
        {
            if($currency->authorised)
            {
                if($request->input('current') !== null && $currency->is_current === 0)
                {
                    $this->toggleCurrentCurrency();
                    $current = true;
                }

                if($currency->is_current === 1) $current = true;

                $currency->update([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'symbol' => mb_strtoupper($symbol),
                    'devaluation' => $request->input('devaluation'),
                    'is_current' => $current
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.update_successful', ['name' => $name]));

                return redirect($this->showRoute($currency, 'details'));
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
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $language, Currency $currency)
    {
        try
        {
            if($currency->authorised)
            {
                if($currency->can_be_deleted)
                {
                    $currency->delete();
                    info_flash_message(trans('auth.info'),
                        trans('general.delete_successful', ['name' => $currency->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_currency'));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('currencies.index'));
    }

    /**
     * @param Request $request
     * @param $language
     * @param Currency $currency
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request, $language, Currency $currency)
    {
        try
        {
            if($currency->authorised)
            {
                if(!$currency->is_current)
                {
                    $this->toggleCurrentCurrency();
                    $currency->update(['is_current' => true ]);
                    info_flash_message(trans('auth.info'),
                        trans('general.activate_successful', ['name' => $currency->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_a_currency'));
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
     * @param  string $name
     * @param int $id
     * @return void
     */
    private function currencyExist($name, $id = 0)
    {
        if(Auth::user()->currencies->where('slug', Auth::user()->id . '-' . str_slug($name))
                ->where('id', '<>', $id)->count() > 0)
        {
            throw ValidationException::withMessages([
                'name' => trans('general.already_exist', ['name' => mb_strtolower($name)]),
            ])->status(423);
        }
    }

    /**
     * Check if the account already exist
     *
     * @param  string $symbol
     * @param int $id
     * @return void
     */
    private function symbolExist($symbol, $id = 0)
    {
        if(Auth::user()->currencies->where('symbol', mb_strtoupper($symbol))
                ->where('id', '<>', $id)->count() > 0)
        {
            throw ValidationException::withMessages([
                'symbol' => trans('general.already_exist', ['name' => mb_strtolower($symbol)]),
            ])->status(423);
        }
    }

    /**
     *
     */
    private function toggleCurrentCurrency()
    {
        Auth::user()->currencies->where('is_current', true)->first()
            ->update(['is_current' => false ]);
    }

    /**
     * @param Currency $currency
     * @param string $tab
     * @return bool
     */
    private function showRoute(Currency $currency, $tab = '')
    {
        if($tab === '') return locale_route('currencies.show', [$currency]);
        else return locale_route('currencies.show', [$currency]) . '?tab=' . $tab;
    }
}
