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
use App\Models\Category;
use App\Models\Currency;
use App\Models\UserSetting;
use App\Models\Transaction;

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
    Route::get('/dashboard/general/accounts/balance', 'DashboardController@accountsBalanceAjax');
    //Route::get('/dashboard/general/categories/fill', 'DashboardController@categoriesAjax');
    Route::get('/dashboard/general/categories/current/day', 'DashboardController@currentDayCategoryAjax');
    Route::get('/dashboard/general/categories/current/week', 'DashboardController@currentWeekCategoryAjax');
    Route::get('/dashboard/general/categories/current/month', 'DashboardController@currentMonthCategoryAjax');
    Route::get('/dashboard/general/categories/current/year', 'DashboardController@currentYearCategoryAjax');
    Route::get('/dashboard/general/categories/current/year/months', 'DashboardController@currentYearMonthsCategoryAjax');
    Route::get('/dashboard/general/categories/current/week/days', 'DashboardController@currentWeekDaysCategoryAjax');
    Route::get('/dashboard/incomes/current/day', 'DashboardIncomesController@currentDayAjax');
    Route::get('/dashboard/incomes/current/week', 'DashboardIncomesController@currentWeekAjax');
    Route::get('/dashboard/incomes/current/month', 'DashboardIncomesController@currentMonthAjax');
    Route::get('/dashboard/incomes/current/year', 'DashboardIncomesController@currentYearAjax');
    Route::get('/dashboard/incomes/current/year/months', 'DashboardIncomesController@currentYearMonthsAjax');
    Route::get('/dashboard/incomes/current/week/days', 'DashboardIncomesController@currentWeekDaysAjax');
    //Route::get('/dashboard/transfers/current/day', 'DashboardTransfersController@currentDayAjax');
    //Route::get('/dashboard/transfers/current/week', 'DashboardTransfersController@currentWeekAjax');
    //Route::get('/dashboard/transfers/current/month', 'DashboardTransfersController@currentMonthAjax');
    //Route::get('/dashboard/transfers/current/year', 'DashboardTransfersController@currentYearAjax');
    //Route::get('/dashboard/transfers/current/year/months', 'DashboardTransfersController@currentYearMonthsAjax');
    //Route::get('/dashboard/transfers/current/week/days', 'DashboardTransfersController@currentWeekDaysAjax');
    Route::get('/dashboard/expenses/current/day', 'DashboardExpensesController@currentDayAjax');
    Route::get('/dashboard/expenses/current/week', 'DashboardExpensesController@currentWeekAjax');
    Route::get('/dashboard/expenses/current/month', 'DashboardExpensesController@currentMonthAjax');
    Route::get('/dashboard/expenses/current/year', 'DashboardExpensesController@currentYearAjax');
    Route::get('/dashboard/expenses/current/year/months', 'DashboardExpensesController@currentYearMonthsAjax');
    Route::get('/dashboard/expenses/current/week/days', 'DashboardExpensesController@currentWeekDaysAjax');
    Route::get('/notifications/viewed', 'NotificationsController@viewedAjax');
    Route::get('/dashboard/general', function () { return redirect(locale_route('dashboard.index')); });
    Route::get('/dashboard/incomes', function () { return redirect(locale_route('dashboard.incomes')); });
    Route::get('/dashboard/transfers', function () { return redirect(locale_route('dashboard.transfers')); });
    Route::get('/dashboard/expenses', function () { return redirect(locale_route('dashboard.expenses')); });
    Route::get('/wallets/report', function () { return redirect(locale_route('wallets.report')); });
    Route::get('/wallets', function () { return redirect(locale_route('wallets.index')); });
    Route::get('/wallets/create', function () { return redirect(locale_route('wallets.create')); });
    Route::get('/wallets/{wallet}/edit', function (Wallet $wallet) { return redirect(locale_route('wallets.edit', [$wallet])); });
    Route::get('/wallets/{wallet}', function (Wallet $wallet) { return redirect(locale_route('wallets.show', [$wallet])); });
    Route::get('/currencies', function () { return redirect(locale_route('currencies.index')); });
    Route::get('/currencies/create', function () { return redirect(locale_route('currencies.create')); });
    Route::get('/currencies/{currency}/edit', function (Currency $currency) { return redirect(locale_route('currencies.edit', [$currency])); });
    Route::get('/currencies/{currency}', function (Currency $currency) { return redirect(locale_route('currencies.show', [$currency])); });
    Route::get('/currencies/{currency}/wallets/create', function (Currency $currency) { return redirect(locale_route('currencies.wallets.create', [$currency])); });
    Route::get('/settings', function () { return redirect(locale_route('settings.index')); });
    Route::get('/settings/create', function () { return redirect(locale_route('settings.create')); });
    Route::get('/settings/{setting}/edit', function (UserSetting $setting) { return redirect(locale_route('settings.edit', [$setting])); });
    Route::get('/settings/{setting}', function (UserSetting $setting) { return redirect(locale_route('settings.show', [$setting])); });
    Route::get('/categories/report', function () { return redirect(locale_route('categories.report')); });
    Route::get('/categories', function () { return redirect(locale_route('categories.index')); });
    Route::get('/categories/create', function () { return redirect(locale_route('categories.create')); });
    Route::get('/categories/{category}/edit', function (Category $category) { return redirect(locale_route('categories.edit', [$category])); });
    Route::get('/transactions/income/report', function () { return redirect(locale_route('transactions.income.report')); });
    Route::get('/transactions/transfer/report', function () { return redirect(locale_route('transactions.transfer.report')); });
    Route::get('/transactions/expense/report', function () { return redirect(locale_route('transactions.expense.report')); });
    Route::get('/transactions', function () { return redirect(locale_route('transactions.index')); });
    Route::get('/transactions/create', function () { return redirect(locale_route('transactions.create')); });
    Route::get('/transactions/{transaction}/edit', function (Transaction $transaction) { return redirect(locale_route('transactions.edit', [$transaction])); });
    Route::get('/transactions/{transaction}', function (Transaction $transaction) { return redirect(locale_route('transactions.show', [$transaction])); });
    Route::get('/wallets/{wallet}/transactions/create', function (Wallet $wallet) { return redirect(locale_route('wallets.transactions.create', [$wallet])); });
    Route::get('/notifications', function () { return redirect(locale_route('notifications.index')); });

    //--Localized app routes...
    Route::get('/{language}/dashboard/general', 'DashboardController@index')->name('dashboard.index');
    Route::get('/{language}/dashboard/incomes', 'DashboardIncomesController@index')->name('dashboard.incomes');
    Route::get('/{language}/dashboard/transfers', 'DashboardTransfersController@index')->name('dashboard.transfers');
    Route::get('/{language}/dashboard/expenses', 'DashboardExpensesController@index')->name('dashboard.expenses');
    Route::get('/{language}/currencies/{currency}/wallets/create', 'WalletController@currencyCreate')->name('currencies.wallets.create');
    Route::get('/{language}/wallets/{wallet}/transactions/create', 'TransactionController@walletCreate')->name('wallets.transactions.create');
    Route::get('/{language}/categories/{category}/transactions/create', 'TransactionController@categoryCreate')->name('categories.transactions.create');
    Route::get('/{language}/wallets/report', 'WalletController@report')->name('wallets.report');
    Route::get('/{language}/transactions/income/report', 'TransactionController@incomeReport')->name('transactions.income.report');
    Route::get('/{language}/transactions/transfer/report', 'TransactionController@transferReport')->name('transactions.transfer.report');
    Route::get('/{language}/transactions/expense/report', 'TransactionController@expenseReport')->name('transactions.expense.report');
    Route::get('/{language}/categories/report', 'CategoryController@report')->name('categories.report');

    Route::post('/{language}/currencies/{currency}/wallets', 'WalletController@currencyStore')->name('currencies.wallets.store');
    Route::post('/{language}/wallets/{wallet}/transactions', 'TransactionController@walletStore')->name('wallets.transactions.store');
    Route::post('/{language}/categories/{category}/transactions', 'TransactionController@categoryStore')->name('categories.transactions.store');
    Route::post('/{language}/transactions/filter', 'TransactionController@filter')->name('transactions.filter');
    Route::post('/{language}/wallets/{wallet}/transactions/filter', 'WalletController@filter')->name('wallets.transactions.filter');
    Route::post('/{language}/categories/{category}/transactions/filter', 'CategoryController@filter')->name('categories.transactions.filter');

    Route::put('/{language}/currencies/activate/{currency}', 'CurrencyController@activate')->name('currencies.activate');
    Route::put('/{language}/settings/activate/{setting}', 'UserSettingController@activate')->name('settings.activate');
    Route::put('/{language}/settings/disable/tips/{setting}', 'UserSettingController@disableTips')->name('settings.tips.disable');
    Route::put('/{language}/settings/enable/tips/{setting}', 'UserSettingController@enableTips')->name('settings.tips.enable');
    Route::put('/{language}/wallets/disable/stat/{wallet}', 'WalletController@disableStat')->name('wallets.stat.disable');
    Route::put('/{language}/wallets/enable/stat/{wallet}', 'WalletController@enableStat')->name('wallets.stat.enable');

    Route::resource('/{language}/wallets', 'WalletController');
    Route::resource('/{language}/currencies', 'CurrencyController');
    Route::resource('/{language}/settings', 'UserSettingController');
    Route::resource('/{language}/categories', 'CategoryController');
    Route::resource('/{language}/transactions', 'TransactionController');
    Route::resource('/{language?}/notifications', 'NotificationsController', ['only' => ['index', 'destroy']]);

    //--Auth routes...
    Route::group(['namespace' => 'Auth'], function() {
        //--Login and register routes...
        Route::get('/login', function () { return redirect(locale_route('login')); });
        Route::get('/register', function () { return redirect(locale_route('register')); });

        //--Account routes...
        Route::post('/user/timezone', 'AccountController@timezoneAjax');
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
        Route::put('/{language}/account', 'AccountController@update');
        Route::put('/{language}/account/password', 'AccountController@changePassword');
        Route::post('/{language}/account/email', 'AccountController@sendLink');

        //--Localized password reset routes...
        Route::get('/{language}/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/{language}/password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/{language}/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/{language}/password/reset/{token}', 'ResetPasswordController@reset');
    });
});

//--Admin routes...
Route::prefix('admin')->group(function() {
    Route::group(['namespace' => 'Admin'], function() {
        Route::get('/', function () { return redirect(route('admin.dashboard.index')); });
        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard.index');
        Route::get('/notifications/viewed', 'NotificationsController@viewedAjax');

        Route::put('/users/disable/{user}', 'UserController@disable')->name('admin.users.disable');
        Route::put('/users/enable/{user}', 'UserController@enable')->name('admin.users.enable');

        Route::resource('/users', 'UserController', [
            'only' => ['index', 'create', 'store', 'show'],
            'names' => ['index' => 'admin.users.index', 'create' => 'admin.users.create',
                'store' => 'admin.users.store', 'show' => 'admin.users.show']
        ]);
        Route::resource('/faqs', 'FaqsController', [
            'names' => ['index' => 'admin.faqs.index', 'create' => 'admin.faqs.create',
                'store' => 'admin.faqs.store', 'show' => 'admin.faqs.show',
                'edit' => 'admin.faqs.edit', 'update' => 'admin.faqs.update',
                'destroy' => 'admin.faqs.destroy']
        ]);
        Route::resource('/notifications', 'NotificationsController', [
            'only' => ['index', 'destroy'],
            'names' => ['index' => 'admin.notifications.index', 'destroy' => 'admin.notifications.destroy']
        ]);
        Route::resource('/messages', 'MessageController', [
            'only' => ['index', 'destroy'],
            'names' => ['index' => 'admin.messages.index', 'destroy' => 'admin.messages.destroy']
        ]);

        //--Auth routes...
        Route::group(['namespace' => 'Auth'], function() {
            //--Admin login routes...
            Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
            Route::post('/login', 'LoginController@login');
            Route::post('/logout', 'LoginController@logout')->name('admin.logout');

            //--Admin password reset routes...
            Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
            Route::post('/password/reset', 'ForgotPasswordController@sendResetLinkEmail');
            Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
            Route::post('/password/reset/{token}', 'ResetPasswordController@reset');

            //--Account routes...
            Route::get('/account/validation/{email}/{token}', 'AccountController@validation')->name('admin.account.validation');
            Route::get('/account', 'AccountController@index')->name('admin.account.index');
            Route::get('/account/password', 'AccountController@password')->name('admin.account.password');
            Route::get('/account/email', 'AccountController@email')->name('admin.account.email');
            Route::put('/account', 'AccountController@update');
            Route::put('/account/password', 'AccountController@changePassword');
            Route::post('/account/email', 'AccountController@sendLink');
        });
    });
});



