@extends('layouts.landing')

@section('landing.layout.title', page_title(trans('general.login')))

@section('page_name', trans('general.login'))

@section('page_desc', trans('auth.enter_credentials'))

@section('page_icon')
    <i class="fa fa-unlock"></i>
@endsection

@section('landing.layout.body')
    <!--Start FAQs Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-zindex-above-showcase">
        <div class="container">
            <div class="row">
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
                        <div class="form-group">
                            @component('components.label-input', [
                                    'name' => 'password', 'label' => trans('general.password'),
                                    'star' => '*'
                                    ])
                                @component('components.input', [
                                    'type' => 'password', 'name' => 'password', 'min_length' => 6,
                                    'value' => old('password'), 'class' => 'form-control'
                                    ])
                                @endcomponent
                            @endcomponent
                        </div>
                        <div class="form-group text-right">
                            @component('components.submit', [
                                'class' => 'btn btn-outline-theme-1 btn-lg',
                                'id' => 'submit', 'name' => 'submit',
                                'value' => trans('auth.login'),
                                'title' => trans('auth.enter_credentials')
                                ])
                            @endcomponent
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ locale_route('register') }}">@lang('auth.register_sign_upped')</a> <br>
                            <a href="{{ locale_route('password.request') }}">@lang('auth.forgotten_pwd')</a>
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