@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.update_currency')))

@section('breadcrumb.title', trans('general.update_currency'))

@section('breadcrumb.message')
    <a href="{{ locale_route('settings.index') }}">@lang('general.currencies')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.update_currency')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-dollar"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.currencies')])
                            @lang('tips.currencies_edit')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <form action="{{ locale_route('currencies.update', [$currency]) }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'name',
                                                       'class' => 'form-control', 'value' => old('name') ?? $currency->name,
                                                       'placeholder'  => trans('general.name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'symbol'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'symbol',
                                                       'class' => 'form-control', 'value' => old('symbol') ?? $currency->symbol,
                                                       'placeholder'  => trans('general.symbol') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'devaluation'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'devaluation', 'min_length' => 1,
                                                       'class' => 'form-control', 'value' => old('devaluation') ?? $currency->devaluation,
                                                       'placeholder'  => trans('general.devaluation') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                            <div class="nk-int-st">
                                                @component('components.textarea', [
                                                   'name' => 'description',
                                                   'class' => 'form-control', 'value' => old('description') ?? $currency->description,
                                                   'placeholder'  => trans('general.description') . '*'
                                                   ])
                                                @endcomponent
                                            </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group text-left">
                                            <div class="toggle-select-act">
                                                @component('components.app.checkbox', [
                                                    'name' => 'current', 'color' => 'green', 'attribute_2' => $currency->is_current === 1 ? 'disabled' : '',
                                                    'label' => trans('general.activated'), 'class' => $currency->is_current === 1 ? 'disabled' : '',
                                                     'attribute_1' => (old('current') ?? ($currency->is_current === 1 ? 'on' : '')) === 'on' ? 'checked' : ''
                                                     ])
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_currency')">
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

@push('breadcrumb.app.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush



