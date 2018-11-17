@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.transactions')))

@section('breadcrumb.title', trans('general.transactions'))

@section('breadcrumb.message')
    <a href="{{ locale_route('transactions.index') }}">
        @lang('general.transactions')
    </a>
    [{{ $transactionService->getDateRange($date_range, \App\Models\Transaction::BEGIN) }} -
    {{ $transactionService->getDateRange($date_range, \App\Models\Transaction::END) }}]
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-random"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currencies Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right pagination">
                        <a href="{{ $transactionService->getMonthChanger($date_range - 1, locale_route('transactions.index'))->href }}" class="btn btn-theme-1 waves-effect">
                            <i class="fa fa-caret-left"></i>
                            {{ $transactionService->getMonthChanger($date_range - 1, locale_route('transactions.index'))->text }}
                        </a>
                        <a href="{{ $transactionService->getMonthChanger($date_range + 1, locale_route('transactions.index'))->href }}"class="btn btn-theme-1 waves-effect">
                            {{ $transactionService->getMonthChanger($date_range + 1, locale_route('transactions.index'))->text }}
                            <i class="fa fa-caret-right"></i>
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.transactions')])
                            @lang('tips.transactions')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.account')</th>
                                        <th class="text-theme-1">@lang('general.category')</th>
                                        <th class="text-theme-1">@lang('general.amount')</th>
                                        <th class="text-theme-1">@lang('general.date')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td><a href="{{ locale_route('transactions.show', [$transaction]) }}" title="@lang('general.details')">{{ text_format($transaction->name, 20) }}</a></td>
                                            <td>
                                                @if($transaction->is_a_transfer)
                                                    <a href="{{ locale_route('wallets.show', [$transaction->transfer_wallet]) }}"
                                                       style="color:{{ $transaction->wallet->color }}"
                                                       title="@lang('general.details')">
                                                        {{ text_format($transaction->wallet->name, 10) }}
                                                    </a>
                                                    <i class="fa fa-long-arrow-right"></i>
                                                    <a href="{{ locale_route('wallets.show', [$transaction->transfer_wallet]) }}"
                                                       style="color:{{ $transaction->transfer_wallet->color }}"
                                                       title="@lang('general.details')">
                                                        {{ text_format($transaction->transfer_wallet->name, 10) }}
                                                    </a>
                                                @else
                                                    <a href="{{ locale_route('wallets.show', [$transaction->wallet]) }}"
                                                       style="color:{{ $transaction->wallet->color }}"
                                                       title="@lang('general.details')">
                                                        {{ text_format($transaction->wallet->name, 20) }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-center" data-toggle="tooltip" data-placement="bottom" title="{{ $transaction->category->name }}">
                                                    <i class="fa fa-{{ $transaction->category->format_type->icon }} {{ $transaction->category->format_type->color }}"></i>
                                                    <i class="fa fa-{{ $transaction->category->icon }}" style="color:{{ $transaction->category->color }};"></i>
                                                </div>
                                            </td>
                                            <td class="text-right">{{ $transaction->format_amount }}</td>
                                            <td>
                                                <div class="text-center" data-toggle="tooltip" data-placement="bottom" title="{{ $transaction->created_time }}">
                                                    {{ $transaction->created_date }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ locale_route('transactions.edit', [$transaction]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                                                @if($transaction->can_be_deleted)
                                                    <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-currency-{{ $transaction->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                                                @endif
                                            </td>
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
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.account')</th>
                                        <th class="text-theme-1">@lang('general.category')</th>
                                        <th class="text-theme-1">@lang('general.amount')</th>
                                        <th class="text-theme-1">@lang('general.date')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagination">
                        <a href="{{ $transactionService->getMonthChanger($date_range - 1, locale_route('transactions.index'))->href }}" class="btn btn-theme-1 waves-effect">
                            <i class="fa fa-caret-left"></i>
                            {{ $transactionService->getMonthChanger($date_range - 1, locale_route('transactions.index'))->text }}
                        </a>
                        <a href="{{ $transactionService->getMonthChanger($date_range + 1, locale_route('transactions.index'))->href }}"class="btn btn-theme-1 waves-effect">
                            {{ $transactionService->getMonthChanger($date_range + 1, locale_route('transactions.index'))->text }}
                            <i class="fa fa-caret-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Currencies Area-->
@endsection



