<!--Start Menu Area-->
<div class="main-menu-area mg-tb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li class="{{ active_page(app_dashboard_pages()) }}">
                        <a data-toggle="tab" href="#dashboard">
                            <i class="fa fa-pie-chart"></i>
                            @lang('general.dashboard')
                        </a>
                    </li>
                    <li class="{{ active_page(app_transaction_pages()) }}">
                        <a data-toggle="tab" href="#transaction">
                            <i class="fa fa-exchange"></i>
                            @lang('general.transaction')
                        </a>
                    </li>
                    <li class="{{ active_page(app_wallet_pages()) }}">
                        <a data-toggle="tab" href="#account">
                            <i class="fa fa-credit-card"></i>
                            @lang('general.account')
                        </a>
                    </li>
                    <li class="{{ active_page(app_currency_pages()) }}">
                        <a data-toggle="tab" href="#currency">
                            <i class="fa fa-dollar"></i>
                            @lang('general.currency')
                        </a>
                    </li>
                    <li class="{{ active_page(app_setting_pages()) }}">
                        <a data-toggle="tab" href="#setting">
                            <i class="fa fa-cogs"></i>
                            @lang('general.setting')
                        </a>
                    </li>
                    <li class="{{ active_page(app_user_pages()) }}">
                        <a data-toggle="tab" href="#user">
                            <i class="fa fa-user"></i>
                            {{ \Illuminate\Support\Facades\Auth::user()->format_full_name }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="dashboard" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_dashboard_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(app_dashboard_pages()) }} waves-effect">
                                <a href="{{ locale_route('dashboard') }}">
                                    <i class="fa fa-bar-chart-o"></i>
                                    @lang('general.dashboard')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="transaction" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(app_transaction_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">

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
                    <div id="user" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
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