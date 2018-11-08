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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <a href="{{ locale_route('wallets.edit', [$wallet]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                            @if($wallet->can_delete)
                                <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-wallet" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header" style="background-color:{{ $wallet->color }};">
                                    <strong class="text-uppercase">{{ $wallet->name }}</strong>
                                </div>
                            </div>
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#transactions">@lang('general.movements')</a></li>
                                    <li><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="transactions" class="tab-pane fade in active">
                                        <div class="alert alert-info text-center" role="alert">
                                            @lang('general.no_data')
                                        </div>
                                    </div>
                                    <div id="details" class="tab-pane fade">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <strong>@lang('general.balance') :</strong>
                                                    <span class="text-success">{{ $wallet->format_balance }}</span>
                                                </li>
                                                <li>
                                                    <strong>@lang('general.threshold') :</strong>
                                                    <span class="text-danger">{{ $wallet->format_threshold }}</span>
                                                </li>
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
                                                <li>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $wallet->created_date }} @lang('general.at') {{ $wallet->created_time }}
                                                </li>
                                                <li>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $wallet->updated_date }} @lang('general.at') {{ $wallet->updated_time }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade">
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

    @if($wallet->can_delete)
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
@endsection



