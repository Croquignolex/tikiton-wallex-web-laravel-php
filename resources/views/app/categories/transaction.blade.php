@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.add_' . $type)))

@section('breadcrumb.title', trans('general.add_' . $type))

@section('breadcrumb.message')
    <a href="{{ locale_route('categories.index') }}">@lang('general.categories')</a>
    <i class="fa fa-caret-right"></i>
    <a href="{{ locale_route('categories.show', [$category]) }}">{{ $category->name }}</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.add_' . $type)
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
                            @lang('tips.transactions_add', ['name' => $category->name ])
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
                            <form action="{{ locale_route('categories.transactions.store', [$category]) }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group mg-b-40 text-left">
                                            <strong class="text-theme-1"><small>@lang('general.category') :</small></strong>
                                            <span style="color:{{ $category->color }};">
                                                <i class="fa fa-{{ $category->icon }}"></i>
                                                {{ text_format($category->name, 50) }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'account'])
                                                @component('components.app.select', [
                                                   'name' => 'account', 'header' => trans('general.select_account')
                                                ])
                                                    @foreach($wallets as $wallet)
                                                        <option value="{{ $wallet->id }}"
                                                                data-subtext="({{ $wallet->format_balance }})"
                                                                {{ $wallet->id === intval(old('account')) ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                    @endforeach
                                                @endcomponent
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'transaction_amount'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'transaction_amount', 'min_length' => 1,
                                                       'class' => 'form-control', 'value' => old('transaction_amount'),
                                                       'placeholder'  => trans('general.amount') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'date'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'date',
                                                       'class' => 'form-control', 'value' => (old('date') ?? $transactionService->getNormalFormatDate(now(), 'tz'))
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group mg-b-40 text-left">
                                            <strong class="text-theme-1"><small>@lang('general.type') :</small></strong>
                                            <span class="{{ $transactionService->getFormatType($type)->color }}">
                                                <i class="fa fa-{{ $transactionService->getFormatType($type)->icon }}"></i>
                                                {{ $transactionService->getFormatType($type)->text }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                            <div class="nk-int-st">
                                                @component('components.textarea', [
                                                   'name' => 'description', 'min_length' => 0,
                                                   'class' => 'form-control', 'value' => old('description'),
                                                   'placeholder'  => trans('general.description')
                                                   ])
                                                @endcomponent
                                            </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.add_' . $type)">
                                                <i class="fa fa-plus"></i>
                                                @lang('general.add')
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
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap-select') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap-datetimepicker') }}" type="text/css">
@endpush

@push('breadcrumb.app.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap-select') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('moment-with-locales') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap-datetimepicker') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#date').datetimepicker({ locale: '{{ \Illuminate\Support\Facades\App::getLocale() }}' });
        });
    </script>
@endpush



