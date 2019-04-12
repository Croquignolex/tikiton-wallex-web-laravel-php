@extends('layouts.admin.layout')

@section('layout.title', page_title(trans('general.login')))

@section('layout.body')
    <!--Start Login Area-->
    <div class="login-content">
        <!-- Login -->
        <div class="nk-block toggled">
            <div class="nk-form" id="form-validation">
                <div class="logo">
                    <a href="{{ locale_route('home') }}">
                        <img src="{{ img_asset('logo') }}" alt="...">
                    </a>
                </div>
                <h5 class="text-uppercase">Connexion</h5>
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
                <form action="" method="POST" @submit="validateFormElements" class="text-right">
                    {{ csrf_field() }}
                    <div class="input-group mg-t-15">
                        @component('components.admin.label-input', ['name' => 'email'])
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
                        @component('components.admin.label-input', ['name' => 'password'])
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
                    <button type="submit" class="btn btn-login btn-theme-2 btn-float" title="{{ trans('auth.enter_credentials') }}">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </form>
            </div>

            <div class="nk-navigation rg-ic-stl">
                <a href="{{ route('admin.password.request') }}" class="password"><i class="fa fa-question"></i> <span>@lang('auth.forgotten_pwd')</span></a>
            </div>
        </div>
    </div>
    <!--End Login Area-->
@endsection

@push('layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush