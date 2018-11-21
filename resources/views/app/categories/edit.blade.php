@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.update_category')))

@section('breadcrumb.title', trans('general.update_category'))

@section('breadcrumb.message')
    <a href="{{ locale_route('categories.index') }}">@lang('general.categories')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.update_category')
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
                        @component('components.tips', ['title' => trans('general.categories')])
                            @lang('tips.categories_edit')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="white-container color-preview"></div></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
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
                            <form action="{{ locale_route('categories.update', [$category]) }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'name',
                                                       'class' => 'form-control', 'value' => old('name') ?? $category->name,
                                                       'placeholder'  => trans('general.name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'icon'])
                                                @component('components.app.select', [
                                                   'name' => 'icon', 'header' => trans('general.select_icon')
                                                ])
                                                    @foreach(icons() as $icon)
                                                        <option value="{{ $icon }}" data-icon="fa-{{ $icon }}"
                                                                {{ $icon === (old('icon') ?? $category->icon) ? 'selected' : '' }}></option>
                                                    @endforeach
                                                @endcomponent
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'color'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'color', 'min_length' => 7, 'max_length' => 7,
                                                       'class' => 'form-control', 'value' => old('color') ?? $category->color,
                                                       'placeholder'  => trans('general.color') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group mg-b-40 text-left">
                                            <strong>@lang('general.type') : </strong>
                                            <span class="{{ $category->format_type->color }}">
                                                <i class="fa fa-{{ $category->format_type->icon }}"></i>
                                                {{ $category->format_type->text }}
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                            <div class="nk-int-st">
                                                @component('components.textarea', [
                                                   'name' => 'description',
                                                   'class' => 'form-control', 'value' => old('description') ?? $category->description,
                                                   'placeholder'  => trans('general.description') . '*'
                                                   ])
                                                @endcomponent
                                            </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_category')">
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




