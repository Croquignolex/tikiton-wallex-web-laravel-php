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
                                    <li class="{{ active_page(collect(['dashboard.index'])) }}">
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
                                        <a data-toggle="collapse" data-target="#mobile-sub-transaction">
                                            <i class="fa fa-plus"></i>
                                            @lang('general.new_transaction')
                                        </a>
                                        <ul id="mobile-sub-transaction" class="collapse dropdown-header-top">
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.create') }}?type={{ \App\Models\Category::INCOME }}">
                                                    <i class="fa fa-arrow-up text-success"></i>
                                                    @lang('general.new_income_transaction')
                                                </a>
                                            </li>
                                            <li class="{{ active_page(collect(['transactions.create'])) }} waves-effect">
                                                <a href="{{ locale_route('transactions.create') }}?type={{ \App\Models\Category::TRANSFER }}">
                                                    <i class="fa fa-exchange text-info"></i>
                                                    @lang('general.new_transfer_transaction')
                                                </a>
                                            </li>
                                            <li class="{{ active_page(collect(['transactions.create'])) }} waves-effect">
                                                <a href="{{ locale_route('transactions.create') }}?type={{ \App\Models\Category::EXPENSE }}">
                                                    <i class="fa fa-arrow-down text-danger"></i>
                                                    @lang('general.new_expense_transaction')
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ active_page(collect(['transactions.income.report'])) }} waves-effect">
                                        <a data-toggle="collapse" data-target="#mobile-sub-incomes-report">
                                            <i class="fa fa-calendar text-success"></i>
                                            @lang('general.incomes_report')
                                        </a>
                                        <ul id="mobile-sub-incomes-report" class="collapse dropdown-header-top">
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.income.report') }}?type={{ \App\Models\Transaction::DAILY }}">
                                                    <i class="fa fa-clock-o"></i>
                                                    @lang('general.daily')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.income.report') }}?type={{ \App\Models\Transaction::WEEKLY }}">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    @lang('general.weekly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.income.report') }}?type={{ \App\Models\Transaction::MONTHLY }}">
                                                    <i class="fa fa-calendar-o"></i>
                                                    @lang('general.monthly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.income.report') }}?type={{ \App\Models\Transaction::YEARLY }}">
                                                    <i class="fa fa-calendar"></i>
                                                    @lang('general.yearly')
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ active_page(collect(['transactions.transfer.report'])) }} waves-effect">
                                        <a data-toggle="collapse" data-target="#mobile-sub-transfers-report">
                                            <i class="fa fa-calendar text-info"></i>
                                            @lang('general.transfers_report')
                                        </a>
                                        <ul id="mobile-sub-transfers-report" class="collapse dropdown-header-top">
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.transfer.report') }}?type={{ \App\Models\Transaction::DAILY }}">
                                                    <i class="fa fa-clock-o"></i>
                                                    @lang('general.daily')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.transfer.report') }}?type={{ \App\Models\Transaction::WEEKLY }}">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    @lang('general.weekly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.transfer.report') }}?type={{ \App\Models\Transaction::MONTHLY }}">
                                                    <i class="fa fa-calendar-o"></i>
                                                    @lang('general.monthly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.transfer.report') }}?type={{ \App\Models\Transaction::YEARLY }}">
                                                    <i class="fa fa-calendar"></i>
                                                    @lang('general.yearly')
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ active_page(collect(['transactions.expense.report'])) }} waves-effect">
                                        <a data-toggle="collapse" data-target="#mobile-sub-expenses-report">
                                            <i class="fa fa-calendar text-danger"></i>
                                            @lang('general.expenses_report')
                                        </a>
                                        <ul id="mobile-sub-expenses-report" class="collapse dropdown-header-top">
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.expense.report') }}?type={{ \App\Models\Transaction::DAILY }}">
                                                    <i class="fa fa-clock-o"></i>
                                                    @lang('general.daily')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.expense.report') }}?type={{ \App\Models\Transaction::WEEKLY }}">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    @lang('general.weekly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.expense.report') }}?type={{ \App\Models\Transaction::MONTHLY }}">
                                                    <i class="fa fa-calendar-o"></i>
                                                    @lang('general.monthly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('transactions.expense.report') }}?type={{ \App\Models\Transaction::YEARLY }}">
                                                    <i class="fa fa-calendar"></i>
                                                    @lang('general.yearly')
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
                                    <li class="{{ active_page(collect(['wallets.report'])) }} waves-effect">
                                        <a href="{{ locale_route('wallets.report') }}">
                                            <i class="fa fa-calendar"></i>
                                            @lang('general.accounts_report')
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
                                    <li class="{{ active_page(collect(['categories.report'])) }} waves-effect">
                                        <a data-toggle="collapse" data-target="#mobile-sub-categories-report">
                                            <i class="fa fa-calendar"></i>
                                            @lang('general.categories_report')
                                        </a>
                                        <ul id="mobile-sub-categories-report" class="collapse dropdown-header-top">
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('categories.report') }}?type={{ \App\Models\Transaction::DAILY }}">
                                                    <i class="fa fa-clock-o"></i>
                                                    @lang('general.daily')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('categories.report') }}?type={{ \App\Models\Transaction::WEEKLY }}">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    @lang('general.weekly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('categories.report') }}?type={{ \App\Models\Transaction::MONTHLY }}">
                                                    <i class="fa fa-calendar-o"></i>
                                                    @lang('general.monthly')
                                                </a>
                                            </li>
                                            <li class="waves-effect">
                                                <a href="{{ locale_route('categories.report') }}?type={{ \App\Models\Transaction::YEARLY }}">
                                                    <i class="fa fa-calendar"></i>
                                                    @lang('general.yearly')
                                                </a>
                                            </li>
                                        </ul>
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