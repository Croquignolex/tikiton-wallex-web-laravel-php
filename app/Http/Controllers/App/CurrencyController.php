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
        $currencies = collect();
        try
        {
            $currencies = Auth::user()->currencies->sortByDesc('updated_at');
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
        $this->currencyExist($name);
        $this->symbolExist($symbol);

        try
        {
            $currency = Auth::user()->currencies()->create([
                'name' => $name,
                'description' => $request->input('description'),
                'symbol' =>  mb_strtoupper($symbol),
                'devaluation' => $request->input('devaluation')
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
        try
        {
            $currency->load('wallets');
            if($currency->authorised) return view('app.currencies.show', compact('currency'));
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

        try
        {
            if($currency->authorised)
            {
                $currency->update([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'symbol' => mb_strtoupper($symbol),
                    'devaluation' => $request->input('devaluation')
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.update_successful', ['name' => $name]));

                return redirect($this->showRoute($currency));
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
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_account'));
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
     * Check if the account already exist
     *
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
     * @param Currency $currency
     * @return bool
     */
    private function showRoute(Currency $currency)
    {
        return locale_route('currencies.show', [$currency]);
    }
}
