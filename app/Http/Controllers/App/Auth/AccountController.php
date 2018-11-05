<?php

namespace App\Http\Controllers\App\Auth;

use Exception;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Traits\ErrorFlashMessagesTrait;

class AccountController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->only('validation');
        $this->middleware('auth')->except('validation');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('account.index', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {
        return view('account.password');
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
                $user->password = Hash::make($request->input('password'));
                $user->save();
                success_flash_message(trans('auth.success'), trans('passwords.changed'));
            }
            else
            {
                danger_flash_message(trans('auth.error'), trans('passwords.password_not_match'));
                return redirect(locale_route('account.password'));
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return $this->redirectTo();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function email()
    {
        return view('account.email');
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
            $user->email = $request->email;
            $user->is_confirmed = false;
            $user->save();

            try
            {
                //TODO: Edit contact form email
                //Mail::to($user->email)->send(new UserEmailChangeMail($user));
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

        return $this->redirectTo();
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
                'token' => $token, 'email' => $email, 'is_confirmed' => false,
                'is_admin' => false, 'is_super_admin' => false
            ])->first();

            if($user === null)
                danger_flash_message(trans('auth.error'), trans('general.bad_link'));
            else
            {
                $user->is_confirmed = true;
                $user->token = str_random(64);
                $user->save();

                $setting = Setting::where('is_activated', true)->first();
                if($setting !== null)
                {
                    if($setting->receive_email_from_register)
                    {
                        try
                        {
                            //TODO: Edit contact form email
                            $this->userFactoryData($user);
                            //Mail::to(config('company.email_1'))->send(new NewCustomerMail($user));
                        }
                        catch (Exception $exception)
                        {
                            $this->mailError($exception);
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function redirectTo()
    {
        return redirect(locale_route('account.index'));
    }

    private function userFactoryData(User $user)
    {
        //Default settings
        $user->settings()->create([
            'name' => 'Novice',
            'is_current' => true,
            'description' => 'This is the best way for you to learn'
        ]);
        $user->settings()->create([
            'tips' => false,
            'name' => 'Expert',
            'is_current' => false,
            'description' => 'You know what you are doing, feel free'
        ]);
        //Default currencies
        $user->currencies()->create([
            'name' => 'FCFA',
            'description' => 'Center Africa currency',
            'devaluation' => 0,
            'symbol' => 'XAF',
            'is_current' => true
        ]);
        $user->currencies()->create([
            'name' => 'US DOLLAR',
            'description' => 'USA currency',
            'devaluation' => 550,
            'symbol' => '$',
        ]);
        $user->currencies()->create([
            'name' => 'POUNDS',
            'description' => 'England currency',
            'devaluation' => 1000,
            'symbol' => '£'
        ]);
        //Default wallet
        $user->wallets()->create([
            'balance' => 0,
            'threshold' => 1000,
            'stated' => true,
            'description' => 'Personal wallet',
            'color' => '#C257B8',
            'name' => 'Wallet'
        ]);
        $user->wallets()->create([
            'balance' => 0,
            'threshold' => 15000,
            'stated' => true,
            'description' => 'Current account in UBA bank: 115165469269',
            'color' => '#4CAF50',
            'name' => 'Current'
        ]);
        $user->wallets()->create([
            'balance' => 0,
            'threshold' => 50000,
            'stated' => false,
            'description' => 'Saving account in UBA bank: 115165469269',
            'color' => '#F44336',
            'name' => 'Saving'
        ]);
    }
}
