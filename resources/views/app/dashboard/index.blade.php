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
                        'symbol' => $currency->symbol,
                        'color' => 'text-theme-1'
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.stated_accounts'),
                        'id' => 'accounts-widget',
                        'value' => $accounts_nbr,
                        'route' => locale_route('wallets.index'),
                        'symbol' => '',
                        'color' => 'text-theme-1'
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.all_categories'),
                        'id' => 'categories-widget',
                        'value' => $all_categories,
                        'route' => locale_route('categories.index'),
                        'symbol' => '',
                        'color' => 'text-theme-1'
                    ])
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
                       'loader_id' => 'accounts-loader',
                       'chart_id' => 'accounts-chart',
                       'event_function_name' => 'accounts_refresh'
                    ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                            'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::DAILY,
                            'title' => trans('general.daily_category_chart'),
                            'title_date' => $transactionService->getDayFormatDate(now()),
                            'loader_id' => 'daily-category-loader',
                            'chart_id' => 'daily-category-chart',
                            'event_function_name' => 'daily_category_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                           'title' => trans('general.weekly_category_chart'),
                           'title_date' => $transactionService->getDayFormatDate(now()),
                           'loader_id' => 'weekly-category-loader',
                           'chart_id' => 'weekly-category-chart',
                           'event_function_name' => 'weekly_category_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::MONTHLY,
                           'title' => trans('general.monthly_category_chart'),
                           'title_date' => $transactionService->getMonthFormatDate(now()),
                           'loader_id' => 'monthly-category-loader',
                           'chart_id' => 'monthly-category-chart',
                           'event_function_name' => 'monthly_category_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::YEARLY,
                           'title' => trans('general.yearly_category_chart'),
                           'title_date' => now()->year,
                           'loader_id' => 'yearly-category-loader',
                           'chart_id' => 'yearly-category-chart',
                           'event_function_name' => 'yearly_category_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                       'title' => trans('general.details_daily_category_chart'),
                       'title_date' => $transactionService->getWeekFormatDate(now()),
                       'loader_id' => 'days-category-loader',
                       'chart_id' => 'days-category-chart',
                       'event_function_name' => 'days_category_refresh'
                    ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('categories.report') . '?type=' . \App\Models\Transaction::YEARLY,
                       'title' => trans('general.details_yearly_category_chart'),
                       'title_date' => now()->year,
                       'loader_id' => 'months-category-loader',
                       'chart_id' => 'months-category-chart',
                       'event_function_name' => 'months_category_refresh'
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







