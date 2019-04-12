<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Setting;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;
use App\Traits\ErrorFlashMessagesTrait;

class ContactController extends Controller
{
    use ErrorFlashMessagesTrait;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('ajax')->only(['timezoneAjax']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function send(ContactRequest $request)
    {
        try
        {
            $contact = Contact::create($request->all());

            success_flash_message(trans('auth.success'), trans('general.contact_send'));

            $setting = Setting::where('is_activated', true)->first();
            if($setting !== null)
            {
                if($setting->receive_email_from_contact)
                {
                    try
                    {
                        $timezone = $request->session()->get('timezone', function (){
                            return config('company.admin_timezone');
                        });
                        session(['timezone' => config('company.admin_timezone')]);
                        Mail::to(config('company.email_1'))->send(new ContactFormMail($contact));
                        session(['timezone' => $timezone]);
                    }
                    catch (Exception $exception)
                    {
                        $this->mailError($exception);
                    }
                }
            }
        }
        catch (Exception $exception)
        {
            $this->databaseError($exception);
        }

        return redirect(locale_route('contact'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function timezoneAjax(Request $request)
    {
        session(['timezone' => $request->input('timezone')]);
        return response()->json();
    }
}
