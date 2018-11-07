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
                            @if(!$currency->is_current)
                                <a href="javascript: void(0);" class="text-danger hand-cursor" data-toggle="modal" data-target="#delete-currency" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>&nbsp;
                                <a href="javascript: void(0);" class="text-success hand-cursor" data-toggle="modal" data-target="#activate-currency" title="@lang('general.activate')"><i class="fa fa-check"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header">
                                    <strong class="text-uppercase">{{ $currency->name }}</strong>
                                </div>
                            </div>
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="details" class="tab-pane fade in active">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <strong>@lang('general.symbol') :</strong>
                                                    {{ $currency->symbol }}
                                                </li>
                                                <li>
                                                    <strong>@lang('general.devaluation') :</strong>
                                                    {{ $currency->format_devaluation }}
                                                </li>
                                                <li>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $currency->created_date }} @lang('general.at') {{ $currency->created_time }}
                                                </li>
                                                <li>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $currency->updated_date }} @lang('general.at') {{ $currency->updated_time }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade">
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

    @if(!$currency->is_current)
        @component('components.modal', [
            'title' => trans('general.delete_currency', ['name' => $currency->name]),
            'id' => 'delete-currency', 'color' => 'modal-danger',
            'action_route' => locale_route('currencies.destroy', [$currency])
            ])
            @lang('general.cfm_action')?
        @endcomponent
        @component('components.modal', [
            'title' => trans('general.activate_currency', ['name' => $currency->name]),
            'id' => 'activate-currency', 'color' => 'modal-success', 'method' => 'PUT',
            'action_route' => locale_route('currencies.activate', [$currency]),
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif
@endsection



