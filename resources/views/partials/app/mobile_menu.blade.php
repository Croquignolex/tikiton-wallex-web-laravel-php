<!--Start Mobile Menu Area-->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li class="{{ active_page(app_dashboard_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_dashboard" href="#">
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
                            <li class="{{ active_page(app_account_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_account" href="#">
                                    <i class="fa fa-credit-card"></i>
                                    @lang('general.account')
                                </a>
                                <ul id="mobile_account" class="collapse dropdown-header-top">

                                </ul>
                            </li>
                            <li class="{{ active_page(app_user_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_user" href="#">
                                    <i class="fa fa-user"></i>
                                    {{ \Illuminate\Support\Facades\Auth::user()->format_full_name }}
                                </a>
                                <ul id="mobile_user" class="collapse dropdown-header-top">
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