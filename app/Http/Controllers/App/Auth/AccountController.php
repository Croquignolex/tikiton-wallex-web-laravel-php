<?php

namespace App\Http\Controllers\App\Auth;

use Exception;
use App\Models\User;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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
            Auth::user()->update(['email' => $request->email, 'is_confirmed' => false]);
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
                'token' => $token, 'email' => $email, 'is_confirmed' => false,
                'is_admin' => false, 'is_super_admin' => false
            ])->first();

            if($user === null) danger_flash_message(trans('auth.error'), trans('general.bad_link'));
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
     * @param User $user
     */
    private function userFactoryData(User $user)
    {
        //Default settings
        $user->user_settings()->create([
            'name' => 'Novice', 'is_current' => true,
            'description' => 'This is the best way for you to learn'
        ]);
        $user->user_settings()->create([
            'tips' => false, 'name' => 'Expert', 'is_current' => false,
            'description' => 'You know what you are doing, feel free'
        ]);
        //Default currencies
        $currency = $user->currencies()->create([
            'name' => 'FCFA', 'devaluation' => 1, 'symbol' => 'XAF',
            'description' => 'Center Africa currency'
        ]);
        $user->currencies()->create([
            'name' => 'US DOLLAR', 'devaluation' => 550, 'symbol' => '$',
            'description' => 'USA currency'
        ]);
        $user->currencies()->create([
            'name' => 'POUNDS', 'devaluation' => 1000, 'symbol' => '£',
            'description' => 'England currency'
        ]);
        //Default wallets
        $personal_wallet = $user->wallets()->create([
            'balance' => 0, 'threshold' => 1000, 'stated' => true,
            'description' => 'Personal wallet', 'name' => 'Wallet',
            'color' => '#e8b4df', 'currency_id' => $currency->id
        ]);
        $current_account_wallet = $user->wallets()->create([
            'balance' => 0, 'threshold' => 15000,
            'description' => 'Current account in UBA bank: 115165469269',
            'color' => '#aad4ac', 'name' => 'Current', 'currency_id' => $currency->id
        ]);
        $saving_account_wallet = $user->wallets()->create([
            'balance' => 0, 'threshold' => 50000, 'is_stated' => false,
            'description' => 'Saving account in UBA bank: 115165469269',
            'color' => '#e08686', 'name' => 'Saving', 'currency_id' => $currency->id
        ]);
        //Default categories
        $income = $user->categories()->create([
            'description' => 'My monthy salary from my office',
            'color' => '#00c292',
            'name' => 'Salary',
            'icon' => 'money',
            'type' => Category::INCOME
        ]);
        $transfer = $user->categories()->create([
            'description' => 'Transfer order from my actually bank',
            'color' => '#2196F3',
            'name' => 'Bank transfer order',
            'icon' => 'bank',
            'type' => Category::TRANSFER
        ]);
        $expense = $user->categories()->create([
            'description' => 'My monthy electricity bill',
            'color' => '#F44336',
            'name' => 'Electricity bill',
            'icon' => 'flash',
            'type' => Category::EXPENSE
        ]);
        //Default transactions
        $income_transaction = $income->transactions()->create([
            'name' => 'Dummy income',
            'description' => 'Dummy income transaction',
            'amount' => 0
        ]);
        $transfer_transaction = $transfer->transactions()->create([
            'name' => 'Dummy transfer',
            'description' => 'Dummy transfer transaction',
            'amount' => 0
        ]);
        $expense_transaction = $expense->transactions()->create([
            'name' => 'Dummy expense',
            'description' => 'Dummy expense transaction',
            'amount' => 0
        ]);
        $income_transaction->wallets()->save($personal_wallet);
        $transfer_transaction->wallets()->save($current_account_wallet);
        $transfer_transaction->wallets()->save($saving_account_wallet);
        $expense_transaction->wallets()->save($personal_wallet);
    }

    /**
     * @return bool
     */
    private function indexRoute()
    {
        return locale_route('account.index');
    }
}
