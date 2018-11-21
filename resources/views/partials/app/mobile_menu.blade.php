<!--Start Mobile Menu Area-->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li class="{{ active_page(app_dashboard_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_dashboard">
                                    <i class="fa fa-pie-chart"></i>
                                    @lang('general.dashboard')
                                </a>
                                <ul class="collapse dropdown-header-top">
                                    <li class="{{ active_page(app_dashboard_pages()) }}">
                                        <a href="{{ locale_route('dashboard') }}">
                                            <i class="fa fa-bar-chart-o"></i>
                                            @lang('general.dashboard')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(app_transaction_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_transaction">
                                    <i class="fa fa-random"></i>
                                    @lang('general.transaction')
                                </a>
                                <ul id="mobile_transaction" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['transactions.index'])) }} waves-effect">
                                        <a href="{{ locale_route('transactions.index') }}">
                                            <i class="fa fa-random"></i>
                                            @lang('general.transactions')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['transactions.create'])) }} waves-effect">
                                        <a data-toggle="collapse" data-target="#mobile_sub_transaction">
                                            <i class="fa fa-plus"></i>
                                            @lang('general.new_transaction')
                                        </a>
                                        <ul id="mobile_sub_transaction" class="collapse dropdown-header-top">
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.create') }}?type={{ \App\Models\Category::INCOME }}">
                                                    <span class="text-success">
                                                        <i class="fa fa-arrow-up"></i>
                                                        @lang('general.new_income_transaction')
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="{{ active_page(collect(['transactions.create'])) }} waves-effect">
                                                <a href="{{ locale_route('transactions.create') }}?type={{ \App\Models\Category::TRANSFER }}">
                                                    <span class="text-info">
                                                        <i class="fa fa-exchange"></i>
                                                        @lang('general.new_transfer_transaction')
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="{{ active_page(collect(['transactions.create'])) }} waves-effect">
                                                <a href="{{ locale_route('transactions.create') }}?type={{ \App\Models\Category::EXPENSE }}">
                                                    <span class="text-danger">
                                                        <i class="fa fa-arrow-down"></i>
                                                        @lang('general.new_expense_transaction')
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(app_wallet_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_account">
                                    <i class="fa fa-credit-card"></i>
                                    @lang('general.account')
                                </a>
                                <ul id="mobile_account" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['wallets.index'])) }}">
                                        <a href="{{ locale_route('wallets.index') }}">
                                            <i class="fa fa-credit-card"></i>
                                            @lang('general.accounts')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['wallets.create'])) }}">
                                        <a href="{{ locale_route('wallets.create') }}">
                                            <i class="fa fa-plus"></i>
                                            @lang('general.new_account')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(app_category_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_category">
                                    <i class="fa fa-database"></i>
                                    @lang('general.category')
                                </a>
                                <ul id="mobile_category" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['categories.index'])) }}">
                                        <a href="{{ locale_route('categories.index') }}">
                                            <i class="fa fa-database"></i>
                                            @lang('general.categories')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['categories.create'])) }}">
                                        <a href="{{ locale_route('categories.create') }}">
                                            <i class="fa fa-plus"></i>
                                            @lang('general.new_category')
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ active_page(app_currency_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_currency">
                                    <i class="fa fa-dollar"></i>
                                    @lang('general.currency')
                                </a>
                                <ul id="mobile_currency" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['currencies.index'])) }}">
                                        <a href="{{ locale_route('currencies.index') }}">
                                            <i class="fa fa-dollar"></i>
                                            @lang('general.currencies')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['currencies.create'])) }}">
                                        <a href="{{ locale_route('currencies.create') }}">
                                            <i class="fa fa-plus"></i>
                                            @lang('general.new_currency')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(app_setting_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_setting">
                                    <i class="fa fa-cogs"></i>
                                    @lang('general.setting')
                                </a>
                                <ul id="mobile_setting" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['settings.index'])) }}">
                                        <a href="{{ locale_route('settings.index') }}">
                                            <i class="fa fa-cogs"></i>
                                            @lang('general.settings')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['settings.create'])) }}">
                                        <a href="{{ locale_route('settings.create') }}">
                                            <i class="fa fa-plus"></i>
                                            @lang('general.new_setting')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(app_user_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_user">
                                    <i class="fa fa-user"></i>
                                    {{ text_format(\Illuminate\Support\Facades\Auth::user()->format_full_name, 40) }}
                                </a>
                                <ul id="mobile_user" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['account.index'])) }} waves-effect">
                                        <a href="{{ locale_route('account.index') }}">
                                            <i class="fa fa-user"></i>
                                            @lang('general.edit_profile')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['account.email'])) }} waves-effect">
                                        <a href="{{ locale_route('account.email') }}">
                                            <i class="fa fa-at"></i>
                                            @lang('general.change_email')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['account.password'])) }} waves-effect">
                                        <a href="{{ locale_route('account.password') }}">
                                            <i class="fa fa-lock"></i>
                                            @lang('general.change_password')
                                        </a>
                                    </li>
                                    <li>
                                        <a class="logout" href="javascript: void(0);"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i>
                                            @lang('general.log_out')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Mobile Menu Area-->