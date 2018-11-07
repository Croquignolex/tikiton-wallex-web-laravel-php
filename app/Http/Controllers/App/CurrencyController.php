<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;
use App\Http\Requests\CurrencyRequest;
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
        $currencies = null;

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
        $this->currencyExist($request->input('name'));

        try
        {
            if($request->input('current') != null)
            {
                foreach (Auth::user()->currencies as $currency)
                {
                    $currency->is_current = false;
                    $currency->save();
                }
            }

            $currency = Auth::user()->currencies()->create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'symbol' => $request->input('symbol'),
                'devaluation' => $request->input('devaluation'),
                'is_current' => $request->input('current') == null ? false : true
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $request->input('name')]));

            return redirect(locale_route('currencies.show', [$currency]));
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
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, Currency $currency)
    {
        try
        {
            if($currency->authorised)
                return view('app.currencies.show', compact('currency'));
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
            if($currency->authorised)
                return view('app.currencies.edit', compact('currency'));
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
     * @param CurrencyRequest $request
     * @param $language
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, $language, Currency $currency)
    {
        $this->currencyExist($request->input('name'), $currency->id);

        try
        {
            $current = false;
            if($request->input('current') != null && $currency->is_current === 0)
            {
                foreach (Auth::user()->currencies as $user_currency)
                {
                    $user_currency->is_current = false;
                    $user_currency->save();
                }
                $current = true;
            }

            if($currency->is_current === 1)
                $current = true;

            $currency->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'symbol' => $request->input('symbol'),
                'devaluation' => $request->input('devaluation'),
                'is_current' => $current
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.update_successful', ['name' => $request->input('name')]));

            return redirect(locale_route('currencies.show', [$currency]));
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
     * @param Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $language, Currency $currency)
    {
        try
        {
            if($currency->authorised)
            {
                if(!$currency->is_current)
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

        return redirect($this->redirectTo());
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
                    foreach (Auth::user()->currencies as $user_currency)
                    {
                        $user_currency->is_current = false;
                        $user_currency->save();
                    }

                    $currency->is_current = true;
                    $currency->save();
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
     * Give the redirection path
     *
     * @return Router
     */
    private function redirectTo()
    {
        return locale_route('currencies.index');
    }
}
