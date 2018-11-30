@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.app')

@section('app.layout.title', page_title(trans('general.expenses')))

@section('app.layout.body')
    <div class="widgets-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.daily_expense'),
                        'id' => 'daily-widget',
                        'value' => $daily,
                        'route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::DAILY,
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.weekly_expense'),
                        'id' => 'weekly-widget',
                        'value' => $weekly,
                        'route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.monthly_expense'),
                        'id' => 'monthly-widget',
                        'value' => $monthly,
                        'route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::MONTHLY,
                        'symbol' => $currency->symbol
                    ])
                    @endcomponent
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    @component('components.app.dashboard-widget', [
                        'name' => trans('general.yearly_expense'),
                        'id' => 'yearly-widget',
                        'value' => $yearly,
                        'route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::YEARLY,
                        'symbol' => $currency->symbol
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
                        @lang('tips.dashboard_expenses')
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
                            'report_route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::DAILY,
                            'title' => trans('general.daily_expense_chart'),
                            'title_date' => $transactionService->getDayFormatDate(now()),
                            'loader_id' => 'daily-loader',
                            'chart_id' => 'daily-chart',
                            'event_function_name' => 'daily_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                           'title' => trans('general.weekly_expense_chart'),
                           'title_date' => $transactionService->getDayFormatDate(now()),
                           'loader_id' => 'weekly-loader',
                           'chart_id' => 'weekly-chart',
                           'event_function_name' => 'weekly_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::MONTHLY,
                           'title' => trans('general.monthly_expense_chart'),
                           'title_date' => $transactionService->getMonthFormatDate(now()),
                           'loader_id' => 'monthly-loader',
                           'chart_id' => 'monthly-chart',
                           'event_function_name' => 'monthly_refresh'
                        ])
                        @endcomponent
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        @component('components.app.dashboard-chart', [
                           'report_route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::YEARLY,
                           'title' => trans('general.yearly_expense_chart'),
                           'title_date' => now()->year,
                           'loader_id' => 'yearly-loader',
                           'chart_id' => 'yearly-chart',
                           'event_function_name' => 'yearly_refresh'
                        ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::WEEKLY,
                       'title' => trans('general.details_daily_expense_chart'),
                       'title_date' => $transactionService->getWeekFormatDate(now()),
                       'loader_id' => 'days-loader',
                       'chart_id' => 'days-chart',
                       'event_function_name' => 'days_refresh'
                    ])
                    @endcomponent
                </div>
                <div class="col-xs-12">
                    @component('components.app.dashboard-chart', [
                       'report_route' => locale_route('transactions.expense.report') . '?type=' . \App\Models\Transaction::YEARLY,
                       'title' => trans('general.details_yearly_expense_chart'),
                       'title_date' => now()->year,
                       'loader_id' => 'months-loader',
                       'chart_id' => 'months-chart',
                       'event_function_name' => 'months_refresh'
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
    <script src="{{ js_app_asset('expenses-dashboard') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('types-dashboard') }}" type="text/javascript"></script>
@endpush