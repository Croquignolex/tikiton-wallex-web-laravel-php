<?php

namespace App\Http\Controllers\App\Auth;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Traits\ErrorFlashMessagesTrait;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, ErrorFlashMessagesTrait;

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.app.register');
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request)
    {
        try
        {
            $user = new User();
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->last_name = $request->input('last_name');
            $user->first_name = $request->input('first_name');
            $user->save();
            try
            {
                //TODO: Edit contact form email
                //Mail::to($user->email)->send(new UserRegisterMail($user));
                success_flash_message(trans('auth.success'), trans('auth.registration_message'));
            }
            catch (Exception $exception)
            {
                $user->delete();
                $this->mailError($exception);
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('register'));
    }
}