@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.account_details')))

@section('breadcrumb.title', trans('general.account_details'))

@section('breadcrumb.message')
    <a href="{{ locale_route('wallets.index') }}">@lang('general.accounts')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.account_details')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-credit-card"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.accounts')])
                            @lang('tips.accounts_details')
                        @endcomponent
                    </div>
                    <div class="col-md-6 col-md-push-6 col-sm-8 col-sm-push-4 col-xs-12">
                        @component('components.date-range', [
                            'begin_date' => $transactionService->getNormalFormatDate($begin_date),
                            'end_date' => $transactionService->getNormalFormatDate($end_date),
                            'route' => locale_route('wallets.transactions.filter', [$wallet])
                         ])
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <a href="{{ locale_route('wallets.edit', [$wallet]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                            @if($wallet->can_be_deleted)
                                <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-wallet" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header" style="background-color:{{ $wallet->color }};">
                                    <strong class="text-uppercase">{{ $wallet->name }}</strong>
                                </div>
                            </div>
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs"><li class="{{ $tab !== 'details' ? 'active' : '' }}"><a data-toggle="tab" href="#transactions">@lang('general.movements')</a></li>
                                    <li class="{{ $tab === 'details' ? 'active' : '' }}"><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="transactions" class="tab-pane fade {{ $tab !== 'details' ? 'in active' : '' }} table-responsive">
                                        <div class="text-right">
                                            <a href="javascript: void(0);" data-toggle="modal" data-target="#add-transaction">
                                                <i class="fa fa-plus"></i>
                                                @lang('general.add_transaction')
                                            </a>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            [{{ $transactionService->getMediumFormatDate($begin_date) }} -
                                            {{ $transactionService->getMediumFormatDate($end_date) }}]
                                            ({{ $transactions->count() }})
                                        </div>
                                        @component('components.app.transaction-table',
                                           ['transactions' => $transactions, 'no_action' => '6'])
                                        @endcomponent
                                    </div>
                                    <div id="details" class="tab-pane fade {{ $tab === 'details' ? 'in active' : '' }}">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.balance') :</strong>
                                                    <span class="text-success">{{ $wallet->format_balance }}</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.threshold') :</strong>
                                                    <span class="text-danger">{{ $wallet->format_threshold }}</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.currency') :</strong>
                                                    <a href="{{ locale_route('currencies.show', [$wallet->currency]) }}"
                                                        title="@lang('general.details')">{{ $wallet->currency->name }}</a>
                                                    ({{ $wallet->currency->symbol }})
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.stated') :</strong>
                                                    <small class="text-{{ $wallet->format_stated->color }}">
                                                        {{ $wallet->format_stated->text }}
                                                    </small>
                                                    @if($wallet->is_stated)
                                                        <a href="javascript: void(0);" class="text-warning" data-toggle="modal" data-target="#disable-stat"
                                                           title="@lang('general.disable')"><i class="fa fa-times"></i></a>
                                                    @else
                                                        <a href="javascript: void(0);" class="text-info" data-toggle="modal" data-target="#enable-stat"
                                                           title="@lang('general.enable')"><i class="fa fa-check"></i></a>
                                                    @endif
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $wallet->long_created_date }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $wallet->long_updated_date }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade overflow">
                                        <div class="tab-ctn">
                                            <p class="multi-line-text">{{ $wallet->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Setting Area-->

    @if($wallet->can_be_deleted)
        @component('components.modal', [
            'title' => trans('general.delete_account', ['name' => $wallet->name]),
            'id' => 'delete-wallet', 'color' => 'modal-danger',
            'action_route' => locale_route('wallets.destroy', [$wallet])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif

    @if($wallet->is_stated)
        @component('components.modal', [
            'title' => trans('general.disable_stat', ['name' => $wallet->name]),
            'id' => 'disable-stat', 'color' => 'modal-warning', 'method' => 'PUT',
            'action_route' => locale_route('wallets.stat.disable', [$wallet])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @else
        @component('components.modal', [
            'title' => trans('general.enable_stat', ['name' => $wallet->name]),
            'id' => 'enable-stat', 'color' => 'modal-info', 'method' => 'PUT',
            'action_route' => locale_route('wallets.stat.enable', [$wallet])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif

    @component('components.app.new-transaction-modal', [
        'id' => 'add-transaction',
        'route' => locale_route('wallets.transactions.create', [$wallet])
    ])
    @endcomponent
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

