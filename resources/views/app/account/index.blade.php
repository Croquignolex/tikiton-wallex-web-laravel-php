@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.edit_profile')))

@section('breadcrumb.title', trans('general.edit_profile'))

@section('breadcrumb.message')
    <a href="{{ locale_route('account.index') }}">{{ text_format($user->format_full_name, 50) }}</a>
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-user"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.profile')])
                            @lang('tips.account_edit')
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
                            <form action="" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'first_name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'first_name',
                                                       'class' => 'form-control', 'value' => old('first_name') ?? $user->first_name,
                                                       'placeholder'  => trans('general.first_name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'last_name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'last_name',
                                                       'class' => 'form-control', 'value' => old('last_name') ?? $user->last_name,
                                                       'placeholder'  => trans('general.last_name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'address'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'address',
                                                       'class' => 'form-control', 'value' => old('address') ?? $user->address,
                                                       'placeholder'  => trans('general.address'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'post_code'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'post_code',
                                                       'class' => 'form-control', 'value' => old('post_code') ?? $user->post_code,
                                                       'placeholder'  => trans('general.post_code'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'phone'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'phone',
                                                       'class' => 'form-control', 'value' => old('phone') ?? $user->phone,
                                                       'placeholder'  => trans('general.phone'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'city'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'city',
                                                       'class' => 'form-control', 'value' => old('city') ?? $user->city,
                                                       'placeholder'  => trans('general.city'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'country'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'country',
                                                       'class' => 'form-control', 'value' => old('country') ?? $user->country,
                                                       'placeholder'  => trans('general.country'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'profession'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'profession',
                                                       'class' => 'form-control', 'value' => old('profession') ?? $user->profession,
                                                       'placeholder'  => trans('general.profession'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'description'])
                                                <div class="nk-int-st">
                                                    @component('components.textarea', [
                                                       'name' => 'description',
                                                       'class' => 'form-control', 'value' => old('description') ?? $user->description,
                                                       'placeholder'  => trans('general.description'), 'min_length' => 0
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_profile')">
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




