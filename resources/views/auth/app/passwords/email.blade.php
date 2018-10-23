@extends('layouts.landing')

@section('landing.layout.title', page_title(trans('general.pwd_reset')))

@section('page_name', trans('general.pwd_reset'))

@section('page_desc', trans('auth.enter_email'))

@section('page_icon')
    <i class="fa fa-repeat"></i>
@endsection

@section('landing.layout.body')
    <!--Start FAQs Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-zindex-above-showcase">
        <div class="container">
            <div class="row">
                @if(session()->has('notification.message'))
                    <div class="text-center col-sm-10 col-sm-offset-1">
                        <div class="alert alert-{{ session('notification.type') }} alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('notification.message') }}
                        </div>
                    </div>
                @endif
                <form action="" method="POST" class="probootstrap-form" @submit="validateFormElements">
                    {{ csrf_field() }}
                    <div class="col-md-6 col-md-offset-3 probootstrap-animate" data-animate-effect="fadeIn">
                        <div class="form-group">
                            @component('components.label-input', [
                                    'name' => 'email', 'label' => trans('general.email'),
                                    'star' => '*'
                                    ])
                                @component('components.input', [
                                    'type' => 'email', 'name' => 'email',
                                    'class' => 'form-control', 'value' => old('email')
                                    ])
                                @endcomponent
                            @endcomponent
                        </div>
                        <div class="form-group text-right">
                            @component('components.submit', [
                                'class' => 'btn btn-outline-theme-1 btn-lg',
                                'id' => 'submit', 'name' => 'submit',
                                'value' => trans('auth.send_reset_link'),
                                'title' => trans('auth.enter_email')
                                ])
                            @endcomponent
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ locale_route('register') }}">@lang('auth.register_sign_upped')</a> <br>
                            <a href="{{ locale_route('login') }}">@lang('auth.login_sign_upped')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--End FAQs Area-->
@endsection

@push('landing.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush