@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.categories_report')))

@section('breadcrumb.title', trans('general.categories_report'))

@section('breadcrumb.message')
    <a href="{{ locale_route('categories.index') }}">@lang('general.categories')</a> (3)
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
                            <a data-toggle="popover" data-placement="left" data-content="{{ $transactionService->getDateRangeChanger($date_range - 1, $type, locale_route('categories.report'))->last() }}"
                               href="{{ $transactionService->getDateRangeChanger($date_range - 1, $type, locale_route('categories.report'))->first() }}" class="btn btn-theme-1" data-trigger="hover">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <a data-toggle="popover" data-placement="right" data-content="{{ $transactionService->getDateRangeChanger($date_range + 1, $type, locale_route('categories.report'))->last() }}"
                               href="{{ $transactionService->getDateRangeChanger($date_range + 1, $type, locale_route('categories.report'))->first() }}" class="btn btn-theme-1" data-trigger="hover">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.reports')])
                            @lang('tips.categories_report')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <div class="text-center">
                                <h4 class="text-theme-1">
                                    ({{ $transactionService->getDateRangeChanger($date_range, $type, locale_route('categories.report'))->last() }})
                                </h4>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                [{{ $transactionService->getMediumFormatDate($begin_date) }} -
                                {{ $transactionService->getMediumFormatDate($end_date) }}]
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.amount') ({{ $current_currency->symbol }})</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <i class="fa fa-arrow-up text-success"></i>
                                            @lang('general.incomes')
                                        </td>
                                        <td class="text-right">{{ $incomes_amount }}</td>
                                    </tr>
                                    <tr class="current">
                                        <td>2</td>
                                        <td class="text-info">
                                            <i class="fa fa-exchange text-info"></i>
                                            @lang('general.transfers')
                                        </td>
                                        <td class="text-right">{{ $transfer_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td class="text-danger">
                                            <i class="fa fa-arrow-down text-danger"></i>
                                            @lang('general.expenses')
                                        </td>
                                        <td class="text-right">{{ $expenses_amount }}</td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="text-uppercase">
                                        <th colspan="2" class="text-theme-1">@lang('general.total')</th>
                                        <th class="text-right">
                                            @if($total > 0)
                                                <span class="text-success">{{ $total }}</span>
                                            @elseif($total < 0)
                                                <span class="text-danger">{{ $total }}</span>
                                            @else
                                                <span class="text-primary">{{ $total }}</span>
                                            @endif

                                        </th>
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



