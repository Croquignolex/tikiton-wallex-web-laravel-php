@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.app')

@section('app.layout.title', page_title(trans('general.general')))

@section('app.layout.body')
    <div class="widgets-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.accounts_balance'),
                        'id' => 'accounts-balance-widget',
                        'value' => $accounts_balance,
                        'route' => locale_route('wallets.report'),
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.stated_accounts'),
                        'id' => 'accounts-widget',
                        'value' => $accounts_nbr,
                        'route' => locale_route('wallets.index'),
                        'symbol' => ''
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.all_categories'),
                        'id' => 'categories-widget',
                        'value' => $all_categories,
                        'route' => locale_route('categories.index'),
                        'symbol' => ''
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    <div class="tips-area mg-t-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @component('components.tips', ['title' => trans('general.dashboard')])
                        @lang('tips.dashboard_general')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    <div class="charts-area mg-t-20" id="chart-refresh">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('wallets.report'),
                       'title' => trans('general.accounts_balance_chart'),
                       'title_date' => $transactionService->getDayFormatDate(now()),
                       'loader_id' => 'accounts-balance-loader',
                       'chart_id' => 'accounts-balance-chart',
                       'event_function_name' => 'accounts_balance_refresh'
                    ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                            'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::DAILY,
                            'title' => trans('general.current_day_category_chart'),
                            'title_date' => $transactionService->getDayFormatDate(now()),
                            'loader_id' => 'current-day-category-loader',
                            'chart_id' => 'current-day-category-chart',
                            'event_function_name' => 'current_day_category_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                           'title' => trans('general.current_week_category_chart'),
                           'title_date' => $transactionService->getWeekFormatDate(now()),
                           'loader_id' => 'current-week-category-loader',
                           'chart_id' => 'current-week-category-chart',
                           'event_function_name' => 'current_week_category_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::MONTHLY,
                           'title' => trans('general.current_month_category_chart'),
                           'title_date' => $transactionService->getMonthFormatDate(now()),
                           'loader_id' => 'current-month-category-loader',
                           'chart_id' => 'current-month-category-chart',
                           'event_function_name' => 'current_month_category_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::YEARLY,
                           'title' => trans('general.current_year_category_chart'),
                           'title_date' => now()->year,
                           'loader_id' => 'current-year-category-loader',
                           'chart_id' => 'current-year-category-chart',
                           'event_function_name' => 'current_year_category_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                       'title' => trans('general.current_week_days_category_chart'),
                       'title_date' => $transactionService->getWeekFormatDate(now()),
                       'loader_id' => 'current-week-days-category-loader',
                       'chart_id' => 'current-week-days-category-chart',
                       'event_function_name' => 'current_week_days_category_refresh'
                    ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::YEARLY,
                       'title' => trans('general.current_year_months_category_chart'),
                       'title_date' => now()->year,
                       'loader_id' => 'current-year-months-category-loader',
                       'chart_id' => 'current-year-months-category-chart',
                       'event_function_name' => 'current_year_months_category_refresh'
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection

@push('app.layout.script.page')
    <script src="{{ js_app_asset('jquery.sparkline.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('Chart.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('dashboard') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('general-dashboard') }}" type="text/javascript"></script>
@endpush







