@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.update_setting')))

@section('breadcrumb.title', trans('general.update_setting'))

@section('breadcrumb.message')
    <a href="{{ locale_route('settings.index') }}">@lang('general.settings')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.update_setting')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-cogs"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.settings')])
                            @lang('tips.settings_edit')
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
                            <form action="{{ locale_route('settings.update', [$setting]) }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'name',
                                                       'class' => 'form-control', 'value' => old('name') ?? $setting->name,
                                                       'placeholder'  => trans('general.name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group text-left">
                                            <div class="toggle-select-act">
                                                @component('components.app.checkbox', [
                                                   'name' => 'tips', 'color' => 'blue',
                                                   'label' => trans('general.tips'),
                                                   'attribute_1' => (old('tips') ?? ($setting->tips === 1 ? 'on' : '')) === 'on' ? 'checked' : ''
                                                   ])
                                                @endcomponent
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                @if($setting->is_current === 1)
                                                    <span class="text-theme-1">@lang('general.activate')</span>
                                                @else
                                                    @component('components.app.checkbox', [
                                                        'name' => 'current', 'color' => 'green',
                                                        'label' => trans('general.activated'),
                                                        'attribute_1' => old('current') === 'on' ? 'checked' : ''
                                                     ])
                                                    @endcomponent
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                            <div class="nk-int-st">
                                                @component('components.textarea', [
                                                   'name' => 'description', 'min_length' => 0,
                                                   'class' => 'form-control', 'value' => old('description') ?? $setting->description,
                                                   'placeholder'  => trans('general.description')
                                                   ])
                                                @endcomponent
                                            </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_setting')">
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



