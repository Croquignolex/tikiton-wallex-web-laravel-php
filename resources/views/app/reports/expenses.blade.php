@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.expenses_report')))

@section('breadcrumb.title', trans('general.expenses_report'))

@section('breadcrumb.message')
    <a href="{{ locale_route('transactions.index') }}">@lang('general.transactions')</a>
    ({{ $transactions->count() }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-calendar"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Wallets Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="text-center col-xs-12">
                        <div class="pagination">
                            <a data-toggle="popover" data-placement="left" data-content="{{ $transactionService->getDateRangeChanger($date_range - 1, $type)->last() }}"
                               href="{{ $transactionService->getDateRangeChanger($date_range - 1, $type, locale_route('transactions.expense.report'))->first() }}" class="btn btn-danger" data-trigger="hover">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <a data-toggle="popover" data-placement="right" data-content="{{ $transactionService->getDateRangeChanger($date_range + 1, $type)->last() }}"
                               href="{{ $transactionService->getDateRangeChanger($date_range + 1, $type, locale_route('transactions.expense.report'))->first() }}" class="btn btn-danger" data-trigger="hover">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.reports')])
                            @lang('tips.expenses_report')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <div class="text-center">
                                <h4 class="text-danger">
                                    ({{ $transactionService->getDateRangeChanger($date_range, $type)->last() }})
                                </h4>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                [{{ $transactionService->getMediumFormatDate($begin_date) }} -
                                {{ $transactionService->getMediumFormatDate($end_date) }}]
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr class="text-uppercase">
                                    <th><span class="text-danger">#</span></th>
                                    <th><span class="text-danger">@lang('general.name')</span></th>
                                    <th><span class="text-danger">@lang('general.account')</span></th>
                                    <th><span class="text-danger">@lang('general.category')</span></th>
                                    <th><span class="text-danger">@lang('general.date')</span></th>
                                    <th><span class="text-danger">@lang('general.amount')</span></th>
                                    <th><span class="text-danger">@lang('general.amount') ({{ $current_currency->symbol }})</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($transactions as $transaction)
                                    <tr class="{{ !$transaction->is_stated ? 'current' : '' }}">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <span class="text-right" data-content="{{ $transaction->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ $transaction->table_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-right" data-content="{{ $transaction->wallet->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ $transaction->wallet->table_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-center" data-content="{{ $transaction->category->name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                <i class="fa fa-{{ $transaction->category->icon }}"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-right" data-content="{{ $transaction->created_time }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                {{ $transaction->created_date }}
                                            </div>
                                        </td>
                                        <td class="text-right">{{ $transaction->format_amount }}</td>
                                        <td class="text-right">{{ $transaction->format_current_currency_balance }}</td>
                                    </tr>
                                @empty
                                    <td colspan="7" class="text-center">
                                        <div class="text-center">
                                            <div class="alert alert-info text-center" role="alert">
                                                @lang('general.no_data')
                                            </div>
                                        </div>
                                    </td>
                                @endforelse
                                </tbody>
                                <thead>
                                <tr class="text-uppercase">
                                    <th colspan="6"><span class="text-danger">@lang('general.total')</span></th>
                                    <th class="text-right"><span class="text-danger">{{ $total }}</span></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Wallets Area-->
@endsection



