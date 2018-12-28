@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.currency_details')))

@section('breadcrumb.title', trans('general.currency_details'))

@section('breadcrumb.message')
    <a href="{{ locale_route('currencies.index') }}">@lang('general.currencies')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.currency_details')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-dollar"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currency Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.currencies')])
                            @lang('tips.currencies_details')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <a href="{{ locale_route('currencies.edit', [$currency]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>
                            @if($currency->can_be_deleted)
                                &nbsp;<a href="javascript: void(0);" class="text-danger hand-cursor" data-toggle="modal" data-target="#delete-currency" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                            @endif
                            @if(!$currency->is_current)
                                &nbsp;<a href="javascript: void(0);" class="text-success" data-toggle="modal" data-target="#activate-currency" title="@lang('general.activate')"><i class="fa fa-check"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header">
                                    <strong class="text-uppercase">{{ $currency->name }}</strong>
                                </div>
                            </div>
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs">
                                    <li class="{{ $tab !== 'details' ? 'active' : '' }}"><a data-toggle="tab" href="#accounts">@lang('general.accounts')</a></li>
                                    <li class="{{ $tab === 'details' ? 'active' : '' }}"><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="accounts" class="tab-pane fade {{ $tab !== 'details' ? 'in active' : '' }} table-responsive">
                                        <div class="text-right mg-b-15">
                                            <a href="{{ locale_route('currencies.wallets.create', [$currency]) }}">
                                                <i class="fa fa-plus"></i>
                                                @lang('general.add_account')
                                            </a>
                                        </div>
                                        <div>
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-uppercase">
                                                        <th class="text-theme-1">#</th>
                                                        <th class="text-theme-1">@lang('general.name')</th>
                                                        <th class="text-theme-1">@lang('general.balance')</th>
                                                        <th class="text-theme-1">@lang('general.threshold')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($wallets as $wallet)
                                                        <tr class="{{ !$wallet->is_stated ? 'current' : '' }}">
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>
                                                                <a data-content="{{ $wallet->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom"
                                                                   href="{{ locale_route('wallets.show', [$wallet]) }}"
                                                                   style="color:{{ $wallet->color }}">
                                                                    {{ $wallet->table_name }}
                                                                </a>
                                                            </td>
                                                            <td><span class="text-success">{{ $wallet->format_balance }}</span></td>
                                                            <td><span class="text-danger">{{ $wallet->format_threshold }}</span></td>
                                                        </tr>
                                                    @empty
                                                        <td colspan="4" class="text-center">
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
                                                        <th class="text-theme-1">@lang('general.balance')</th>
                                                        <th class="text-theme-1">@lang('general.threshold')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="details" class="tab-pane fade {{ $tab === 'details' ? 'in active' : '' }}">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.symbol') :</strong>
                                                    <span class="text-theme-1">{{ $currency->symbol }}</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.devaluation') :</strong>
                                                    <span class="text-theme-1">{{ $currency->format_devaluation }}</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $currency->long_created_date }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $currency->long_updated_date }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade overflow">
                                        <div class="tab-ctn">
                                            <p class="multi-line-text">{{ $currency->description }}</p>
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
    <!--End Currency Area-->

    @if($currency->can_be_deleted)
        @component('components.modal', [
            'title' => trans('general.delete_currency', ['name' => $currency->name]),
            'id' => 'delete-currency', 'color' => 'modal-danger',
            'action_route' => locale_route('currencies.destroy', [$currency])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif
    @if(!$currency->is_current)
        @component('components.modal', [
            'title' => trans('general.activate_currency', ['name' => $currency->name]),
            'id' => 'activate-currency', 'color' => 'modal-success',
            'action_route' => locale_route('currencies.activate', [$currency]),
            'method' => 'PUT'
        ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif
@endsection



