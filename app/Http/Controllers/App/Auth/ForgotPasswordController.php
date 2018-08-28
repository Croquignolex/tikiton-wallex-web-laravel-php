<?php

namespace App\Http\Controllers\App\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\UserPasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Traits\ResetPasswordUserTrait;
use App\Traits\ErrorFlashMessagesTrait;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    const RESET_LINK_NOT_SENT = 'error';

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, ErrorFlashMessagesTrait,
        ResetPasswordUserTrait;

    /**
     * ForgotPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @return string
     */
    protected function sendResetLink(array $credentials)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return Password::INVALID_USER;
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.

        return $this->SendResetEmail($user) ? Password::RESET_LINK_SENT :
            ForgotPasswordController::RESET_LINK_NOT_SENT;
    }

    /**
     * @param User $user
     * @return bool
     */
    protected function SendResetEmail(User $user)
    {
        try
        {
            $password_reset = PasswordReset::where(['email' => $user->email])->first();

            if(is_null($password_reset)) PasswordReset::create(['email' => $user->email]);
            else
            {
                $password_reset->token = str_random(64);
                $password_reset->save();
            }

            try
            {
                Mail::to($user->email)->send(new UserPasswordResetMail($user));
                return true;
            }
            catch (Exception $exception)
            {
                $this->mailError($exception);
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }
        return false;
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        info_flash_message(trans('auth.info'), trans($response));
        return back()->with('status', trans($response));
    }

    /**
     * @param Request $request
     * @param $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if($response !== ForgotPasswordController::RESET_LINK_NOT_SENT)
            danger_flash_message(trans('auth.error'), trans($response));

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}