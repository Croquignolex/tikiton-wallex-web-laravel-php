<!--Start Mobile Menu Area-->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li class="{{ active_page(admin_dashboard_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_dashboard">
                                    <i class="fa fa-pie-chart"></i>
                                    @lang('general.dashboard')
                                </a>
                                <ul class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['admin.dashboard.index'])) }}">
                                        <a href="{{ route('admin.dashboard.index') }}">
                                            <i class="fa fa-bar-chart-o"></i>
                                            @lang('general.general')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(admin_users_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_users">
                                    <i class="fa fa-users"></i>
                                    Utilisateurs
                                </a>
                                <ul class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['admin.users.index'])) }}">
                                        <a href="{{ route('admin.users.index') }}">
                                            <i class="fa fa-users"></i>
                                            Utilisateurs
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['admin.users.create'])) }} waves-effect">
                                        <a href="{{ route('admin.users.create') }}">
                                            <i class="fa fa-plus"></i>
                                            Nouvel utilisateur
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(admin_users_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_faqs">
                                    <i class="fa fa-question-circle"></i>
                                    FAQs
                                </a>
                                <ul class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['admin.faqs.index'])) }} waves-effect">
                                        <a href="{{ route('admin.faqs.index') }}">
                                            <i class="fa fa-question-circle"></i>
                                            FAQs
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['admin.faqs.create'])) }} waves-effect">
                                        <a href="{{ route('admin.faqs.create') }}">
                                            <i class="fa fa-plus"></i>
                                            Nouvel FAQs
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ active_page(admin_account_pages()) }}">
                                <a data-toggle="collapse" data-target="#mobile_user">
                                    <i class="fa fa-user"></i>
                                    {{ text_format(\Illuminate\Support\Facades\Auth::user()->format_full_name, 40) }}
                                </a>
                                <ul id="mobile_user" class="collapse dropdown-header-top">
                                    <li class="{{ active_page(collect(['admin.account.index'])) }} waves-effect">
                                        <a href="{{ route('admin.account.index') }}">
                                            <i class="fa fa-user"></i>
                                            @lang('general.edit_profile')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['admin.account.email'])) }} waves-effect">
                                        <a href="{{ route('admin.account.email') }}">
                                            <i class="fa fa-at"></i>
                                            @lang('general.change_email')
                                        </a>
                                    </li>
                                    <li class="{{ active_page(collect(['admin.account.password'])) }} waves-effect">
                                        <a href="{{ route('admin.account.password') }}">
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