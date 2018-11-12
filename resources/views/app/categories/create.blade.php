@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.new_category')))

@section('breadcrumb.title', trans('general.new_category'))

@section('breadcrumb.message')
    <a href="{{ locale_route('categories.index') }}">@lang('general.categories')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.new_category')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-database"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currency Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.categories')])
                            @lang('tips.categories_new')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="white-container color-preview"></div></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <form action="{{ locale_route('categories.store') }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'name',
                                                       'class' => 'form-control', 'value' => old('name'),
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
                                                        <option value="{{ $icon }}" data-icon="fa-{{ $icon }}"></option>
                                                    @endforeach
                                                @endcomponent
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'color'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'color', 'min_length' => 7, 'max_length' => 7,
                                                       'class' => 'form-control', 'value' => old('color'),
                                                       'placeholder'  => trans('general.color') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group mg-b-40">
                                            @component('components.app.label-input', ['name' => 'type'])
                                                @component('components.app.select', [
                                                   'name' => 'type', 'header' => trans('general.select_type')
                                                ])
                                                    <option value="{{ \App\Models\Category::INCOME }}" data-content="<i class='fa fa-arrow-up text-success'></i> {{ trans('general.income') }}"></option>
                                                    <option value="{{ \App\Models\Category::TRANSFER }}" data-content="<i class='fa fa-exchange text-info'></i> {{ trans('general.transfer') }}"></option>
                                                    <option value="{{ \App\Models\Category::EXPENSE }}" data-content="<i class='fa fa-arrow-down text-danger'></i> {{ trans('general.expense') }}"></option>
                                                @endcomponent
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                            <div class="nk-int-st">
                                                @component('components.textarea', [
                                                   'name' => 'description',
                                                   'class' => 'form-control', 'value' => old('description'),
                                                   'placeholder'  => trans('general.description') . '*'
                                                   ])
                                                @endcomponent
                                            </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.new_group')">
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



