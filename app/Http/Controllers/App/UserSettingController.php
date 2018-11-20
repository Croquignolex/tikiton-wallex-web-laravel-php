<?php

namespace App\Http\Controllers\App;

use Exception;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\ErrorFlashMessagesTrait;
use App\Http\Requests\UserSettingRequest;
use Illuminate\Validation\ValidationException;

class UserSettingController extends Controller
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
        $settings = collect();
        try
        {
            $settings = Auth::user()->user_settings
                ->sortByDesc('updated_at')->sortByDesc('is_current');
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        $this->paginate($request, $settings, 10, 3);
        $paginationTools = $this->paginationTools;

        return view('app.settings.index', compact('paginationTools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserSettingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSettingRequest $request)
    {
        $name = $request->input('name');
        $current = $request->input('current');
        $this->settingExist($name);

        try
        {
            if($current != null) $this->toggleCurrentSetting();

            $setting = Auth::user()->user_settings()->create([
                'name' => $name,
                'description' => $request->input('description'),
                'tips' => $request->input('tips') == null ? false : true,
                'is_current' => $current == null ? false : true
            ]);

            success_flash_message(trans('auth.success'),
                trans('general.add_successful', ['name' => $name]));

            return redirect($this->showRoute($setting));
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
     * @param UserSetting $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $language, UserSetting $setting)
    {
        try
        {
            if($setting->authorised) return view('app.settings.show', compact('setting'));
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
     * @param UserSetting $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $language, UserSetting $setting)
    {
        try
        {
            if($setting->authorised) return view('app.settings.edit', compact('setting'));
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
     * @param UserSettingRequest $request
     * @param $language
     * @param UserSetting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(UserSettingRequest $request, $language, UserSetting $setting)
    {
        $name = $request->input('name');
        $this->settingExist($name, $setting->id);
        $current = false;

        try
        {
            if($setting->authorised)
            {
                if($request->input('current') !== null && $setting->is_current === 0)
                {
                    $this->toggleCurrentSetting();
                    $current = true;
                }

                if($setting->is_current === 1) $current = true;

                $setting->update([
                    'name' => $name,
                    'description' => $request->input('description'),
                    'tips' => $request->input('tips') == null ? false : true,
                    'is_current' => $current
                ]);

                success_flash_message(trans('auth.success'),
                    trans('general.update_successful', ['name' => $name]));

                return redirect($this->showRoute($setting));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return back()->withInput($request->all());;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $language
     * @param UserSetting $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $language, UserSetting $setting)
    {
        try
        {
            if($setting->authorised)
            {
                if($setting->can_be_deleted)
                {
                    $setting->delete();
                    info_flash_message(trans('auth.info'),
                        trans('general.delete_successful', ['name' => $setting->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_d_setting'));
            }
            else warning_flash_message(trans('auth.warning'), trans('general.not_authorise'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('settings.index'));
    }

    /**
     * @param Request $request
     * @param UserSetting $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request, $language, UserSetting $setting)
    {
        try
        {
            if($setting->authorised)
            {
                if(!$setting->is_current)
                {
                    $this->toggleCurrentSetting();
                    $setting->update(['is_current' => true ]);
                    info_flash_message(trans('auth.info'),
                        trans('general.activate_successful', ['name' => $setting->name]));
                }
                else danger_flash_message(trans('auth.error'), trans('general.c_n_a_setting'));
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
     * @param UserSetting $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableTips(Request $request, $language, UserSetting $setting)
    {
        try
        {
            if($setting->authorised)
            {
                $setting->update(['tips' => false ]);
                info_flash_message(trans('auth.info'),
                    trans('general.disable_tips_successful', ['name' => $setting->name]));
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
     * @param UserSetting $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableTips(Request $request, $language, UserSetting $setting)
    {
        try
        {
            if($setting->authorised)
            {
                $setting->update(['tips' => true ]);
                info_flash_message(trans('auth.info'),
                    trans('general.enable_tips_successful', ['name' => $setting->name]));
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
    private function settingExist($name, $id = 0)
    {
        if(Auth::user()->user_settings->where('slug', Auth::user()->id . '-' . str_slug($name))
                ->where('id', '<>', $id)->count() > 0)
        {
            throw ValidationException::withMessages([
                'name' => trans('general.already_exist', ['name' => mb_strtolower($name)]),
            ])->status(423);
        }
    }

    /**
     *
     */
    private function toggleCurrentSetting()
    {
        Auth::user()->user_settings->where('is_current', true)->first()
            ->update(['is_current' => false ]);
    }

    /**
     * @param UserSetting $userSetting
     * @return bool
     */
    private function showRoute(UserSetting $userSetting)
    {
        return locale_route('settings.show', [$userSetting]);
    }
}
