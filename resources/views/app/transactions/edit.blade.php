@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.update_transaction')))

@section('breadcrumb.title', trans('general.update_transaction'))

@section('breadcrumb.message')
    <a href="{{ locale_route('transactions.index') }}">@lang('general.transactions')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.update_transaction')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-random"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currency Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.transactions')])
                            @lang('tips.transactions_edit')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right" id="form-validation">
                            @if(session()->has('popup.message'))
                                <div class="text-center">
                                    <div class="alert alert-{{ session('popup.type') }} alert-dismissable" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        {{ session('popup.message') }}
                                    </div>
                                </div>
                            @endif
                            <form action="{{ locale_route('transactions.update', [$transaction]) }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'date'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'date',
                                                       'class' => 'form-control', 'value' => (old('date') ?? $transactionService->getNormalFormatDate($transaction->created_at, 'tz'))
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                                <div class="nk-int-st">
                                                    @component('components.textarea', [
                                                       'name' => 'description', 'min_length' => 0,
                                                       'class' => 'form-control', 'value' => old('description') ?? $transaction->description,
                                                       'placeholder'  => trans('general.description')
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group mg-b-15 text-left">
                                            <i class="fa fa-caret-right"></i>
                                            <strong class="text-theme-1"><small>@lang('general.amount') :</small></strong>
                                            {{ $transaction->format_amount }}
                                        </div>
                                        <div class="form-group mg-b-15 text-left">
                                            <i class="fa fa-caret-right"></i>
                                            <strong class="text-theme-1"><small>@lang('general.type') :</small></strong>
                                            <span class="{{ $transactionService->getFormatType($transaction->category->type)->color }}">
                                                <i class="fa fa-{{ $transactionService->getFormatType($transaction->category->type)->icon }}"></i>
                                                {{ $transactionService->getFormatType($transaction->category->type)->text }}
                                            </span>
                                        </div>
                                        <div class="form-group mg-b-15 text-left">
                                            <i class="fa fa-caret-right"></i>
                                            <strong class="text-theme-1"><small>@lang('general.category') :</small></strong>
                                            @if($transaction->category === null)
                                                <span class="text-primary">
                                                    <i class="fa fa-exchange"></i>
                                                    @lang('general.transfer')
                                                </span>
                                            @else
                                                <span style="color: {{ $transaction->category->color }};">
                                                    <i class="fa fa-{{ $transaction->category->icon }}"></i>
                                                    {{ $transaction->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($transaction->is_a_transfer)
                                            <div class="form-group mg-b-15 text-left">
                                                <i class="fa fa-caret-right"></i>
                                                <strong class="text-theme-1"><small>@lang('general.debit_account') :</small></strong>
                                                <span style="color: {{ $transaction->wallet->color }};">
                                                    {{ $transaction->wallet->name }}
                                                </span>
                                            </div>
                                            <div class="form-group mg-b-15 text-left">
                                                <i class="fa fa-caret-right"></i>
                                                <strong class="text-theme-1"><small>@lang('general.credit_account') :</small></strong>
                                                <span style="color: {{ $transaction->transfer_wallet->color }};">
                                                    {{ $transaction->transfer_wallet->name }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="form-group mg-b-15 text-left">
                                                <i class="fa fa-caret-right"></i>
                                                <strong class="text-theme-1"><small>@lang('general.account') :</small></strong>
                                                <span style="color: {{ $transaction->wallet->color }};">
                                                    {{ $transaction->wallet->name }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_transaction')">
                                                <i class="fa fa-plus"></i>
                                                @lang('general.update')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Currency Area-->
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
            $('#date').datetimepicker({ locale: '{{ \Illuminate\Support\Facades\App::getLocale() }}' });
        });
    </script>
@endpush



