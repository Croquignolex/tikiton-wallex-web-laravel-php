@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.transaction_details')))

@section('breadcrumb.title', trans('general.transaction_details'))

@section('breadcrumb.message')
    <a href="{{ locale_route('transactions.index') }}">@lang('general.transactions')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.transaction_details')
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
                        @component('components.tips', ['title' => trans('general.transactions')])
                            @lang('tips.transactions_details')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <a href="{{ locale_route('transactions.edit', [$transaction]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>
                            @if($transaction->can_be_deleted)
                                &nbsp;<a href="javascript: void(0);" class="text-danger hand-cursor" data-toggle="modal" data-target="#delete-transaction" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header">
                                    <strong class="text-uppercase">{{ $transaction->name }}</strong>
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
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.amount') :</strong>
                                                    {{ $transaction->format_amount }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.type') :</strong>
                                                    <span class="{{ $transaction->format_type->color }}">
                                                        <i class="fa fa-{{ $transaction->format_type->icon }}"></i>
                                                        {{ $transaction->format_type->text }}
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.category') :</strong>
                                                    <span style="color: {{ $transaction->category->color }};">
                                                    <i class="fa fa-{{ $transaction->category->icon }}"></i>
                                                        {{ $transaction->category->name }}
                                                    </span>
                                                </li>
                                                @if($transaction->is_a_transfer)
                                                    <li>
                                                        <i class="fa fa-caret-right"></i>
                                                        <strong>@lang('general.debit_account') :</strong>
                                                        <a title="@lang('general.details')" href="{{ locale_route('wallets.show', [$transaction->wallet]) }}">
                                                            {{ $transaction->wallet->name }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-caret-right"></i>
                                                        <strong>@lang('general.credit_account') :</strong>
                                                        <a title="@lang('general.details')" href="{{ locale_route('wallets.show', [$transaction->transfer_wallet]) }}">
                                                            {{ $transaction->transfer_wallet->name }}
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <i class="fa fa-caret-right"></i>
                                                        <strong>@lang('general.account') :</strong>
                                                        <a title="@lang('general.details')" href="{{ locale_route('wallets.show', [$transaction->wallet]) }}">
                                                            {{ $transaction->wallet->name }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $transaction->long_created_date }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $transaction->long_updated_date }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade overflow">
                                        <div class="tab-ctn">
                                            <p class="multi-line-text">{{ $transaction->description }}</p>
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

    @if($transaction->can_be_deleted)
        @component('components.modal', [
            'title' => trans('general.delete_transaction', ['name' => $transaction->name]),
            'id' => 'delete-transaction', 'color' => 'modal-danger',
            'action_route' => locale_route('transactions.destroy', [$transaction])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif
@endsection



