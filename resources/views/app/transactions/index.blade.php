@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.transactions')))

@section('breadcrumb.title', trans('general.transactions'))

@section('breadcrumb.message')
    <a href="{{ locale_route('transactions.index') }}">
        @lang('general.transactions')
    </a>
    [{{ $transactionService->getMediumFormatDate($begin_date) }} -
    {{ $transactionService->getMediumFormatDate($end_date) }}]
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
                    <div class="col-md-6 col-md-push-6 col-sm-8 col-sm-push-4 col-xs-12">
                        @component('components.date-range', [
                            'begin_date' => $transactionService->getNormalFormatDate($begin_date),
                            'end_date' => $transactionService->getNormalFormatDate($end_date)
                         ])
                        @endcomponent
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
                                                <i class="fa fa-{{ $transaction->category->icon }}" style="color:{{ $transaction->category->color }};"></i>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <span class="{{ $transaction->category->format_type->color }}">
                                                <i class="fa fa-{{ $transaction->category->format_type->icon }}"></i>
                                                {{ $transaction->format_amount }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-right" data-toggle="tooltip" data-placement="bottom" title="{{ $transaction->created_time }}">
                                                {{ $transaction->created_date }}
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ locale_route('transactions.edit', [$transaction]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                                            @if($transaction->can_be_deleted)
                                                <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-transaction-{{ $transaction->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
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
                </div>
            </div>
        </div>
    </div>
    <!--End Currencies Area-->

    @foreach($transactions as $transaction)
        @if($transaction->can_be_deleted)
            @component('components.modal', [
                'title' => trans('general.delete_transaction', ['name' => $transaction->name]),
                'id' => 'delete-transaction-' . $transaction->id, 'color' => 'modal-danger',
                'action_route' => locale_route('transactions.destroy', [$transaction])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection

@push('breadcrumb.app.layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap-datetimepicker') }}" type="text/css">
@endpush

@push('breadcrumb.app.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('moment-with-locales') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap-datetimepicker') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            let locale = '{{ \Illuminate\Support\Facades\App::getLocale() }}';
            $('#begin_date').datetimepicker({ locale: locale });
            $('#end_date').datetimepicker({ locale: locale, useCurrent: false });
            $("#begin_date").on("dp.change", function (e) { $('#end_date').data("DateTimePicker").minDate(e.date); });
            $("#end_date").on("dp.change", function (e) { $('#begin_date').data("DateTimePicker").maxDate(e.date); });
        });
    </script>
@endpush


