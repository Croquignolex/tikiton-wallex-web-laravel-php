<!--Start Menu Area-->
<div class="main-menu-area mg-tb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li class="{{ active_page(admin_dashboard_pages()) }}">
                        <a data-toggle="tab" href="#dashboard" title="@lang('general.dashboard')">
                            <i class="fa fa-pie-chart"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(admin_users_pages()) }}">
                        <a data-toggle="tab" href="#users" title="Utilisateurs">
                            <i class="fa fa-users"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(admin_faq_pages()) }}">
                        <a data-toggle="tab" href="#faq" title="FAQs">
                            <i class="fa fa-question-circle"></i>
                        </a>
                    </li>
                    <li class="{{ active_page(admin_account_pages()) }}">
                        <a data-toggle="tab" href="#user">
                            <i class="fa fa-user"></i>
                            {{ text_format(\Illuminate\Support\Facades\Auth::user()->format_full_name, 40) }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="dashboard" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(admin_dashboard_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['admin.dashboard.index'])) }} waves-effect">
                                <a href="{{ route('admin.dashboard.index') }}">
                                    <i class="fa fa-bar-chart-o"></i>
                                    @lang('general.general')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div id="users" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(admin_users_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">
                            <li class="{{ active_page(collect(['admin.users.index'])) }} waves-effect">
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
                    </div>
                    <div id="faq" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(admin_faq_pages()) === 'active' ? 'in active' : '' }}">
                        <ul class="notika-main-menu-dropdown">
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
                    </div>
                    <div id="user" class="tab-pane notika-tab-menu-bg animated flipInX {{ active_page(admin_account_pages()) === 'active' ? 'in active': '' }}">
                        <ul class="notika-main-menu-dropdown">
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