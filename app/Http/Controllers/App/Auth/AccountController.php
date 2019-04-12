<?php

namespace App\Http\Controllers\App\Auth;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Mail\UserEmailChangeMail;
use App\Mail\NewConfirmedUserMail;
use App\Http\Requests\UserRequest;
use App\Http\Requests\EmailRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Traits\UserFactoryDataTrait;
use App\Http\Requests\PasswordRequest;
use App\Traits\ErrorFlashMessagesTrait;

class AccountController extends Controller
{
    use ErrorFlashMessagesTrait, UserFactoryDataTrait;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->only(['validation']);
        $this->middleware('auth')->except(['validation']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('app.account.index', compact('user'));
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserRequest $request)
    {
        try
        {
            $user = Auth::user();
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'post_code' => $request->input('post_code'),
                'phone' => $request->input('phone'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'profession' => $request->input('profession'),
                'description' => $request->input('description'),
            ]);
            success_flash_message(trans('auth.success'),  trans('general.info_updated'));
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->indexRoute());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {
        return view('app.account.password');
    }

    /**
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword(PasswordRequest $request)
    {
        try
        {
            $user = Auth::user();
            if(Hash::check($request->input('old_password'), $user->password))
            {
                $user->update(['password' => Hash::make($request->input('password'))]);
                success_flash_message(trans('auth.success'), trans('passwords.changed'));
            }
            else
            {
                danger_flash_message(trans('auth.error'), trans('passwords.password_not_match'));
                return back()->withInput($request->all());
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->indexRoute());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function email()
    {
        $user = Auth::user();
        return view('app.account.email', compact('user'));
    }

    /**
     * @param EmailRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendLink(EmailRequest $request)
    {
        try
        {
            $user = Auth::user();
            $user->update(['email' => $request->email, 'is_confirmed' => false]);
            try
            {

                Mail::to($user->email)->send(new UserEmailChangeMail($user));
                info_flash_message(trans('auth.info'), trans('auth.email_sent'));
            }
            catch (Exception $exception)
            {
                $this->databaseError($exception);
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect($this->indexRoute());
    }

    /**
     * @param Request $request
     * @param $language
     * @param $email
     * @param $token
     * @return string
     */
    public function validation(Request $request, $language, $email, $token)
    {
        try
        {
            $user = User::where([
                'token' => $token,
                'email' => $email,
                'is_confirmed' => false
            ])->first();

            if($user === null || $user->role->type !== Role::USER) danger_flash_message(trans('auth.error'), trans('general.bad_link'));
            else
            {
                $user->update(['is_confirmed' => true, 'token' => str_random(64)]);
                $setting = Setting::where('is_activated', true)->first();
                if($setting !== null)
                {
                    if($setting->receive_email_from_register)
                    {
                        try
                        {
                            $this->userFactoryData($user);
                            $timezone = $request->session()->get('timezone', function (){
                                return config('company.admin_timezone');
                            });
                            session(['timezone' => config('company.admin_timezone')]);
                            Mail::to(config('company.email_1'))->send(new NewConfirmedUserMail($user));
                            session(['timezone' => $timezone]);
                        }
                        catch (Exception $exception)
                        {
                            $this->mailError($exception);
                            return redirect(locale_route('home'));
                        }
                    }
                }
                success_flash_message(trans('auth.success'),  trans('general.well_confirmed', ['name' => $user->name]));
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('login'));
    }

    /**
     * @return bool
     */
    private function indexRoute()
    {
        return locale_route('account.index');
    }
}
