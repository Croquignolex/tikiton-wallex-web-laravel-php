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
                            <a href="{{ locale_route('currencies.edit', [$currency]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                            @if($currency->can_be_deleted)
                                <a href="javascript: void(0);" class="text-danger hand-cursor" data-toggle="modal" data-target="#delete-currency" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
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
                                    <li class="active"><a data-toggle="tab" href="#accounts">@lang('general.accounts')</a></li>
                                    <li><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="accounts" class="tab-pane fade in active">
                                        <div class="tab-ctn">
                                            <div class="text-right">
                                                <a href="{{ locale_route('currencies.wallets.create', [$currency]) }}">
                                                    <i class="fa fa-plus"></i>
                                                    @lang('general.add_account')
                                                </a>
                                            </div>
                                            <ul>
                                                @forelse($currency->wallets as $wallet)
                                                    <li>
                                                        <i class="fa fa-caret-right"></i>
                                                        <strong>
                                                            <a href="{{ locale_route('wallets.show', [$wallet]) }}"
                                                               title="@lang('general.details')">{{ $wallet->name }}</a> :
                                                        </strong>
                                                        {{ $wallet->format_balance }}
                                                    </li>
                                                @empty
                                                    <div class="text-center">
                                                        <div class="alert alert-info text-center" role="alert">
                                                            @lang('general.no_data')
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="details" class="tab-pane fade">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.symbol') :</strong>
                                                    {{ $currency->symbol }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.devaluation') :</strong>
                                                    {{ $currency->format_devaluation }}
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
@endsection



