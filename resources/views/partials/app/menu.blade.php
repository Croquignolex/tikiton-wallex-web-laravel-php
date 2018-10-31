<!--Start Menu Area-->
<div class="main-menu-area mg-tb-40">
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
                    <li class="{{ active_page(app_account_pages()) }}">
                        <a data-toggle="tab" href="#account">
                            <i class="fa fa-credit-card"></i>
                            @lang('general.account')
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
                    <div id="dashboard" class="tab-pane in active notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(app_dashboard_pages()) }}">
                                <a href="{{ locale_route('dashboard') }}">
                                    <i class="fa fa-bar-chart-o"></i>
                                    @lang('general.dashboard')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="account" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">

                        </ul>
                    </div>
                    <div id="user" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li>
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