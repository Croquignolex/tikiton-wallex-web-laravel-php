@extends('layouts.app.layout')

@section('layout.title', page_title(trans('general.pwd_reset')))

@section('layout.body')
    <!--Start Forgot Password Area-->
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
                    {{ trans('general.pwd_reset') }}
                </h5>
                @if(session()->has('notification.message'))
                    <div class="text-center">
                        <div class="alert alert-{{ session('notification.type') }} alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('notification.message') }}
                        </div>
                    </div>
                @endif
                <form action="" method="POST" @submit="validateFormElements">
                    {{ csrf_field() }}
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
                    <button type="submit" class="btn btn-login btn-success btn-float" title="{{ trans('auth.send_reset_link') }}">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                </form>
            </div>

            <div class="nk-navigation rg-ic-stl">
                <a href="{{ locale_route('login') }}" class="login"><i class="fa fa-arrow-right"></i> <span>@lang('auth.login_sign_upped')</span></a>
                <a href="{{ locale_route('register') }}" class="password"><i class="fa fa-plus"></i> <span>@lang('auth.register_sign_upped')</span></a>
            </div>
        </div>
    </div>
    <!--End Forgot Password Area-->
@endsection

@push('layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush