@extends('layouts.app.layout')

@section('layout.title', page_title(trans('general.register')))

@section('layout.body')
    <!--Start Register Area-->
    <div class="login-content">
        <!-- Login -->
        <div class="nk-block toggled">
            <div class="logo">
                <a href="{{ locale_route('home') }}">
                    <img src="{{ img_asset('logo') }}" alt="...">
                </a>
            </div>
            <div class="nk-form">
                <h5 class="text-uppercase">
                    {{ trans('general.register') }}
                </h5>
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
                    <div class="input-group">
                        @component('components.app.label-input', ['name' => 'first_name'])
                            <span class="input-group-addon nk-ic-st-pro">
                                <i class="fa fa-user"></i>
                            </span>
                            <div class="nk-int-st">
                                @component('components.input', [
                                   'name' => 'first_name', 'attribute' => 'autofocus',
                                   'class' => 'form-control', 'value' => old('first_name'),
                                   'placeholder'  => trans('general.first_name') . '*'
                                   ])
                                @endcomponent
                            </div>
                        @endcomponent
                    </div>
                    <div class="input-group mg-t-15">
                        @component('components.app.label-input', ['name' => 'last_name'])
                            <span class="input-group-addon nk-ic-st-pro">
                                <i class="fa fa-user"></i>
                            </span>
                            <div class="nk-int-st">
                                @component('components.input', [
                                   'name' => 'last_name',
                                   'class' => 'form-control', 'value' => old('last_name'),
                                   'placeholder'  => trans('general.last_name') . '*'
                                   ])
                                @endcomponent
                            </div>
                        @endcomponent
                    </div>
                    <div class="input-group mg-t-15">
                        @component('components.app.label-input', ['name' => 'email'])
                            <span class="input-group-addon nk-ic-st-pro">
                                <i class="fa fa-at"></i>
                            </span>
                            <div class="nk-int-st">
                                @component('components.input', [
                                   'name' => 'email', 'type' => 'email',
                                   'class' => 'form-control', 'value' => old('email'),
                                   'placeholder'  => trans('general.email') . '*'
                                   ])
                                @endcomponent
                            </div>
                        @endcomponent
                    </div>
                    <div class="input-group mg-t-15">
                        @component('components.app.label-input', ['name' => 'password'])
                            <span class="input-group-addon nk-ic-st-pro">
                                <i class="fa fa-lock"></i>
                            </span>
                            <div class="nk-int-st">
                                @component('components.input', [
                                   'name' => 'password', 'type' => 'password',
                                   'class' => 'form-control', 'value' => old('password'),
                                   'placeholder'  => trans('general.password') . '*',
                                   'min_length' => 6
                                   ])
                                @endcomponent
                            </div>
                        @endcomponent
                    </div>
                    <div class="input-group mg-t-15">
                        @component('components.app.label-input', ['name' => 'password_confirmation'])
                            <span class="input-group-addon nk-ic-st-pro">
                                <i class="fa fa-lock"></i>
                            </span>
                            <div class="nk-int-st">
                                @component('components.input', [
                                   'name' => 'password_confirmation', 'type' => 'password',
                                   'class' => 'form-control', 'value' => old('password_confirmation'),
                                   'placeholder'  => trans('general.pwd_cfm') . '*',
                                   'min_length' => 6
                                   ])
                                @endcomponent
                            </div>
                        @endcomponent
                    </div>
                    <button type="submit" class="btn btn-login btn-success btn-float" title="{{ trans('auth.new_account') }}">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </form>
            </div>

            <div class="nk-navigation rg-ic-stl">
                <a href="{{ locale_route('login') }}" class="login"><i class="fa fa-arrow-right"></i> <span>@lang('auth.login_sign_upped')</span></a>
                <a href="{{ locale_route('password.request') }}" class="password"><i class="fa fa-question"></i> <span>@lang('auth.forgotten_pwd')</span></a>
            </div>
        </div>
    </div>
    <!--End Register Area-->
@endsection

@push('layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush