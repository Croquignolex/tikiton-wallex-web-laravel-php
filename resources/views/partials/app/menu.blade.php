<!--Start Menu Area-->
<div class="main-menu-area mg-tb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li class="{{ active_page(app_dashboard_pages()) }}">
                        <a data-toggle="tab" href="#dashboard" title="@lang('general.dashboard')">
                            <i class="fa fa-pie-chart"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(app_transaction_pages()) }}">
                        <a data-toggle="tab" href="#transaction" title="@lang('general.transaction')">
                            <i class="fa fa-random"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(app_wallet_pages()) }}">
                        <a data-toggle="tab" href="#account" title="@lang('general.account')">
                            <i class="fa fa-credit-card"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(app_category_pages()) }}">
                        <a data-toggle="tab" href="#category" title="@lang('general.category')">
                            <i class="fa fa-database"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(app_currency_pages()) }}">
                        <a data-toggle="tab" href="#currency" title="@lang('general.currency')">
                            <i class="fa fa-dollar"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(app_setting_pages()) }}">
                        <a data-toggle="tab" href="#setting" title="@lang('general.setting')">
                            <i class="fa fa-cogs"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(app_user_pages()) }}">
                        <a data-toggle="tab" href="#user">
                            <i class="fa fa-user"></i>
                            {{ text_format(\Illuminate\Support\Facades\Auth::user()->format_full_name, 40) }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="dashboard" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_dashboard_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['dashboard.index'])) }} waves-effect">
                                <a href="{{ locale_route('dashboard.index') }}">
                                    <i class="fa fa-bar-chart-o"></i>
                                    @lang('general.general')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['dashboard.incomes'])) }} waves-effect">
                                <a href="{{ locale_route('dashboard.incomes') }}">
                                    <i class="fa fa-bar-chart-o text-success"></i>
                                    @lang('general.incomes')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['dashboard.transfers'])) }} waves-effect">
                                <a href="{{ locale_route('dashboard.transfers') }}">
                                    <i class="fa fa-bar-chart-o text-info"></i>
                                    @lang('general.transfers')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['dashboard.expenses'])) }} waves-effect">
                                <a href="{{ locale_route('dashboard.expenses') }}">
                                    <i class="fa fa-bar-chart-o text-danger"></i>
                                    @lang('general.expenses')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="transaction" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_transaction_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['transactions.index'])) }} waves-effect">
                                <a href="{{ locale_route('transactions.index') }}">
                                    <i class="fa fa-random"></i>
                                    @lang('general.transactions')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['transactions.create'])) }} waves-effect">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#new-transaction">
                                    <i class="fa fa-plus"></i>
                                    @lang('general.new_transaction')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['transactions.income.report'])) }} waves-effect">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#incomes-report">
                                    <i class="fa fa-table text-success"></i>
                                    @lang('general.incomes_report')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['transactions.transfer.report'])) }} waves-effect">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#transfers-report">
                                    <i class="fa fa-table text-info"></i>
                                    @lang('general.transfers_report')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['transactions.expense.report'])) }} waves-effect">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#expenses-report">
                                    <i class="fa fa-table text-danger"></i>
                                    @lang('general.expenses_report')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="account" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_wallet_pages()) === 'active' ? 'in active': '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['wallets.index'])) }} waves-effect">
                                <a href="{{ locale_route('wallets.index') }}">
                                    <i class="fa fa-credit-card"></i>
                                    @lang('general.accounts')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['wallets.create'])) }} waves-effect">
                                <a href="{{ locale_route('wallets.create') }}">
                                    <i class="fa fa-plus"></i>
                                    @lang('general.new_account')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['wallets.report'])) }} waves-effect">
                                <a href="{{ locale_route('wallets.report') }}">
                                    <i class="fa fa-table"></i>
                                    @lang('general.accounts_report')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="category" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_category_pages()) === 'active' ? 'in active': '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['categories.index'])) }} waves-effect">
                                <a href="{{ locale_route('categories.index') }}">
                                    <i class="fa fa-database"></i>
                                    @lang('general.categories')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['categories.create'])) }} waves-effect">
                                <a href="{{ locale_route('categories.create') }}">
                                    <i class="fa fa-plus"></i>
                                    @lang('general.new_category')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['categories.report'])) }} waves-effect">
                                <a href="javascript: void(0);" data-toggle="modal" data-target="#categories-report">
                                    <i class="fa fa-table"></i>
                                    @lang('general.categories_report')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="currency" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_currency_pages()) === 'active' ? 'in active': '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['currencies.index'])) }} waves-effect">
                                <a href="{{ locale_route('currencies.index') }}">
                                    <i class="fa fa-dollar"></i>
                                    @lang('general.currencies')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['currencies.create'])) }} waves-effect">
                                <a href="{{ locale_route('currencies.create') }}">
                                    <i class="fa fa-plus"></i>
                                    @lang('general.new_currency')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="setting" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_setting_pages()) === 'active' ? 'in active': '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['settings.index'])) }} waves-effect">
                                <a href="{{ locale_route('settings.index') }}">
                                    <i class="fa fa-cogs"></i>
                                    @lang('general.settings')
                                </a>
                            </li>
                            <li class="{{ active_page(collect(['settings.create'])) }} waves-effect">
                                <a href="{{ locale_route('settings.create') }}">
                                    <i class="fa fa-plus"></i>
                                    @lang('general.new_setting')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="user" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_user_pages()) === 'active' ? 'in active': '' }}">
                        <ul class="notika-main-menu-dropdown">
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
                            <li class="waves-effect">
                                <a class="logout" href="javascript: void(0);"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i>
                                    @lang('general.log_out')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Menu Area-->