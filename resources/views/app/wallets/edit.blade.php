@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.update_account')))

@section('breadcrumb.title', trans('general.update_account'))

@section('breadcrumb.message')
    <a href="{{ locale_route('wallets.index') }}">@lang('general.accounts')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.update_account')
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
                            @lang('tips.accounts_edit')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="white-container color-preview"></div></div>
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
                            <form action="{{ locale_route('wallets.update', [$wallet]) }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'name',
                                                       'class' => 'form-control', 'value' => old('name') ?? $wallet->name,
                                                       'placeholder'  => trans('general.name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'balance'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'balance', 'min_length' => 1,
                                                       'class' => 'form-control', 'value' => old('balance') ?? $wallet->balance / $wallet->currency->devaluation,
                                                       'placeholder'  => trans('general.balance') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'threshold'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'threshold', 'min_length' => 1,
                                                       'class' => 'form-control', 'value' => old('threshold') ?? $wallet->threshold / $wallet->currency->devaluation,
                                                       'placeholder'  => trans('general.threshold') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'color'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'color', 'min_length' => 7, 'max_length' => 7,
                                                       'class' => 'form-control', 'value' => old('color') ?? $wallet->color,
                                                       'placeholder'  => trans('general.color') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group mg-b-40">
                                            @component('components.app.label-input', ['name' => 'currency'])
                                                @component('components.app.select', [
                                                   'name' => 'currency', 'header' => trans('general.select_currency')
                                                   ])
                                                    @foreach($currencies as $currency)
                                                        <option value="{{ $currency->id }}" data-subtext="{{ $currency->symbol }}"
                                                            {{ $currency->id == (old('currency') ?? $wallet->currency->id) ? 'selected' : '' }}>{{ $currency->name }}</option>
                                                    @endforeach
                                                @endcomponent
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                            <div class="nk-int-st">
                                                @component('components.textarea', [
                                                   'name' => 'description', 'min_length' => 0,
                                                   'class' => 'form-control', 'value' => old('description') ?? $wallet->description,
                                                   'placeholder'  => trans('general.description')
                                                   ])
                                                @endcomponent
                                            </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group text-left">
                                            <div class="toggle-select-act">
                                                @component('components.app.checkbox', [
                                                   'name' => 'stated', 'color' => 'green',
                                                   'label' => trans('general.stated'),
                                                   'attribute_1' => (old('stated') ?? ($wallet->is_stated === 1 ? 'on' : '')) === 'on' ? 'checked' : ''
                                                   ])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_account')">
                                                <i class="fa fa-repeat"></i>
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
    <!--End Setting Area-->
@endsection

@push('breadcrumb.app.layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap-colorpicker.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap-select') }}" type="text/css">
@endpush

@push('breadcrumb.app.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap-select') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap-colorpicker') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('.color-preview')[0].style.background = $('#color').val();
            $('#color').colorpicker({ format: 'hex' }).on('changeColor', function (e) {
                $('.color-preview')[0].style.background = e.color.toString();
            });
        });
    </script>
@endpush



