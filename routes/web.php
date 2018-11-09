<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Wallet;
use App\Models\Currency;
use App\Models\UserSetting;

//--Landing routes
Route::get('/terms', function () { return redirect(locale_route('terms')); });
Route::get('/policy', function () { return redirect(locale_route('policy')); });
Route::get('/about', function () { return redirect(locale_route('about')); });
Route::get('/faqs', function () { return redirect(locale_route('faqs')); });
Route::get('/contact', function () { return redirect(locale_route('contact')); });

//--Localized landing routes...
Route::get('/{language?}', 'HomeController')->name('home');
Route::get('/{language}/terms', 'TermsController')->name('terms');
Route::get('/{language}/policy', 'PolicyController')->name('policy');
Route::get('/{language}/about', 'AboutController')->name('about');
Route::get('/{language}/faqs', 'FaqsController')->name('faqs');
Route::get('/{language}/contact', 'ContactController@index')->name('contact');

Route::post('/{language}/contact', 'ContactController@send');

//--App routes...
Route::group(['namespace' => 'App'], function() {
    //--App routes...
    Route::get('/dashboard', function () { return redirect(locale_route('dashboard')); });
    Route::get('/wallets', function () { return redirect(locale_route('wallets.index')); });
    Route::get('/wallets/create', function () { return redirect(locale_route('wallets.create')); });
    Route::get('/wallets/{currency}/create', function (Currency $currency) { return redirect(locale_route('wallet.currency.create', [$currency])); });
    Route::get('/wallets/{wallet}/edit', function (Wallet $wallet) { return redirect(locale_route('wallets.edit', [$wallet])); });
    Route::get('/wallets/{wallet}', function (Wallet $wallet) { return redirect(locale_route('wallets.show', [$wallet])); });
    Route::get('/currencies', function () { return redirect(locale_route('currencies.index')); });
    Route::get('/currencies/create', function () { return redirect(locale_route('currencies.create')); });
    Route::get('/currencies/{currency}/edit', function (Currency $currency) { return redirect(locale_route('currencies.edit', [$currency])); });
    Route::get('/currencies/{currency}', function (Currency $currency) { return redirect(locale_route('currencies.show', [$currency])); });
    Route::get('/settings', function () { return redirect(locale_route('settings.index')); });
    Route::get('/settings/create', function () { return redirect(locale_route('settings.create')); });
    Route::get('/settings/{setting}/edit', function (UserSetting $setting) { return redirect(locale_route('settings.edit', [$setting])); });
    Route::get('/settings/{setting}', function (UserSetting $setting) { return redirect(locale_route('settings.show', [$setting])); });

    //--Localized app routes...
    Route::get('/{language}/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/{language}/wallets/{currency}/create', 'WalletController@currencyCreate')->name('wallets.currency.create');

    Route::post('/{language}/wallets/{currency}', 'WalletController@currencyStore')->name('wallets.currency.store');

    Route::put('/{language}/settings/activate/{setting}', 'UserSettingController@activate')->name('settings.activate');
    Route::put('/{language}/settings/disable/tips/{setting}', 'UserSettingController@disableTips')->name('settings.tips.disable');
    Route::put('/{language}/settings/enable/tips/{setting}', 'UserSettingController@enableTips')->name('settings.tips.enable');
    Route::put('/{language}/wallets/disable/stat/{wallet}', 'WalletController@disableStat')->name('wallets.stat.disable');
    Route::put('/{language}/wallets/enable/stat/{wallet}', 'WalletController@enableStat')->name('wallets.stat.enable');

    Route::resource('/{language}/wallets', 'WalletController');
    Route::resource('/{language}/currencies', 'CurrencyController');
    Route::resource('/{language}/settings', 'UserSettingController');

    //--Auth routes...
    Route::group(['namespace' => 'Auth'], function() {
        //--Login and register routes...
        Route::get('/login', function () { return redirect(locale_route('login')); });
        Route::get('/register', function () { return redirect(locale_route('register')); });

        //--Account routes...
        Route::get('/account/validation/{email}/{token}', function ($email, $token) { return redirect(locale_route('account.validation', compact('email', 'token'))); });
        Route::get('/account', function () { return redirect(locale_route('account.index')); });
        Route::get('/account/email', function () { return redirect(locale_route('account.email')); });

        //--Password reset routes...
        Route::get('/password/reset', function () { return redirect(locale_route('password.request')); });
        Route::get('/password/reset/{token}', function ($token) { return redirect(locale_route('password.reset', [$token])); });

        //--Localized login routes...
        Route::get('/{language}/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/{language}/login', 'LoginController@login');
        Route::post('/{language}/logout', 'LoginController@logout')->name('logout');

        //--Localized registration routes...
        Route::get('/{language}/register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/{language}/register', 'RegisterController@register');

        //--Localized account routes...
        Route::get('/{language}/account/validation/{email}/{token}', 'AccountController@validation')->name('account.validation');
        Route::get('/{language}/account', 'AccountController@index')->name('account.index');
        Route::get('/{language}/account/email', 'AccountController@email')->name('account.email');
        Route::get('/{language}/account/password', 'AccountController@password')->name('account.password');
        Route::post('/{language}/account/password', 'AccountController@changePassword');
        Route::post('/{language}/account', 'AccountController@update');
        Route::post('/{language}/account/email', 'AccountController@sendLink');

        //--Localized password reset routes...
        Route::get('/{language}/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/{language}/password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/{language}/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/{language}/password/reset/{token}', 'ResetPasswordController@reset');
    });
});
