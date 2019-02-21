@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.app')

@section('app.layout.title', page_title(trans('general.transfers')))

@section('app.layout.body')
    <div class="widgets-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.daily_transfer'),
                        'id' => 'daily-widget',
                        'value' => $daily,
                        'route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::DAILY,
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.weekly_transfer'),
                        'id' => 'weekly-widget',
                        'value' => $weekly,
                        'route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.monthly_transfer'),
                        'id' => 'monthly-widget',
                        'value' => $monthly,
                        'route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::MONTHLY,
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.yearly_transfer'),
                        'id' => 'yearly-widget',
                        'value' => $yearly,
                        'route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::YEARLY,
                        'symbol' => $currency->symbol,
                        'color' => 'text-success'
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
                        @lang('tips.dashboard_transfers')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    <div class="charts-area mg-t-20" id="chart-refresh">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                            'report_route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::DAILY,
                            'title' => trans('general.current_day_transfer_chart'),
                            'title_date' => $transactionService->getDayFormatDate(now()),
                            'loader_id' => 'current-day-loader',
                            'chart_id' => 'current-day-chart',
                            'event_function_name' => 'current_day_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                           'title' => trans('general.current_week_transfer_chart'),
                           'title_date' => $transactionService->getDayFormatDate(now()),
                           'loader_id' => 'current-week-loader',
                           'chart_id' => 'current-week-chart',
                           'event_function_name' => 'current_week_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::MONTHLY,
                           'title' => trans('general.current_month_transfer_chart'),
                           'title_date' => $transactionService->getMonthFormatDate(now()),
                           'loader_id' => 'current-month-loader',
                           'chart_id' => 'current-month-chart',
                           'event_function_name' => 'current_month_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::YEARLY,
                           'title' => trans('general.current_year_transfer_chart'),
                           'title_date' => now()->year,
                           'loader_id' => 'current-year-loader',
                           'chart_id' => 'current-year-chart',
                           'event_function_name' => 'current_year_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                       'title' => trans('general.current_week_days_transfer_chart'),
                       'title_date' => $transactionService->getWeekFormatDate(now()),
                       'loader_id' => 'current-week-days-loader',
                       'chart_id' => 'current-week-days-chart',
                       'event_function_name' => 'current_week_days_refresh'
                    ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('transactions.transfer.report') . '?type=' . \App\Models\Transaction::YEARLY,
                       'title' => trans('general.current_year_months_transfer_chart'),
                       'title_date' => now()->year,
                       'loader_id' => 'current-year-months-loader',
                       'chart_id' => 'current-year-months-chart',
                       'event_function_name' => 'current_year_months_refresh'
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
    <script src="{{ js_app_asset('transfers-dashboard') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('types-dashboard') }}" type="text/javascript"></script>
@endpush