@extends('layouts.landing.landing')

@section('landing.layout.title', page_title(trans('general.contact')))

@section('page_name', trans('general.contact_us'))

@section('page_desc', trans('general.contact_desc'))

@section('page_icon')
    <i class="fa fa-map-marker"></i>
@endsection

@section('landing.layout.body')
    <!--Start Information Area-->
    <section class="probootstrap-section probootstrap-bg-white">
        <div class="container">
            <div class="row">
                @if(session()->has('popup.message'))
                    <div class="text-center col-sm-10 col-sm-offset-1">
                        <div class="alert alert-{{ session('popup.type') }} alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('popup.message') }}
                        </div>
                    </div>
                @endif
                <div class="col-sm-4 probootstrap-animate text-center" data-animate-effect="fadeInUp">
                    <h2 class="text-theme-1"><i class="fa fa-map-marker"></i></h2>
                    <p>
                        {{ config('company.address_1') }} <br>
                        {{ config('company.address_2') }}
                    </p>
                </div>
                <div class="col-sm-4 probootstrap-animate text-center" data-animate-effect="fadeInUp">
                    <h2 class="text-theme-1"><i class="fa fa-phone"></i></h2>
                    <p>
                        {{ config('company.phone_1') }} <br>
                        {{ config('company.phone_2') }}
                    </p>
                </div>
                <div class="col-sm-4 probootstrap-animate text-center" data-animate-effect="fadeInUp">
                    <h2 class="text-theme-1"><i class="fa fa-envelope-o"></i></h2>
                    <p>
                        {{ config('company.email_1') }} <br>
                        {{ config('company.email_2') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--End Information Area-->

    <!--Start Form Area-->
    <section class="probootstrap-section probootstrap-bg-white">
        <div class="container">
            <div class="row" id="form-validation">
                <form action="" method="POST" class="probootstrap-form" @submit="validateFormElements">
                    {{ csrf_field() }}
                    <div class="col-md-6 probootstrap-animate" data-animate-effect="fadeIn">
                        <div class="form-group">
                            @component('components.label-input', [
                                    'name' => 'name', 'label' => trans('general.name'),
                                    'star' => '*'
                                    ])
                                @component('components.input', [
                                    'name' => 'name', 'attribute' => 'autofocus',
                                    'class' => 'form-control', 'value' => old('name')
                                    ])
                                @endcomponent
                            @endcomponent
                        </div>
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
                                    'name' => 'phone', 'label' => trans('general.phone'),
                                    'star' => '*'
                                    ])
                                @component('components.input', [
                                    'name' => 'phone', 'value' => old('phone'),
                                    'class' => 'form-control',
                                    ])
                                @endcomponent
                            @endcomponent
                        </div>
                    </div>
                    <div class="col-md-6 probootstrap-animate" data-animate-effect="fadeIn">
                        <div class="form-group">
                            @component('components.label-input', [
                                    'name' => 'subject', 'label' => trans('general.subject'),
                                    'star' => '*'
                                    ])
                                @component('components.input', [
                                    'name' => 'subject', 'value' => old('subject'),
                                    'class' => 'form-control'
                                    ])
                                @endcomponent
                            @endcomponent
                        </div>
                        <div class="form-group">
                            @component('components.label-input', [
                                    'name' => 'message', 'label' => trans('general.message'),
                                    'star' => '*'
                                    ])
                                @component('components.textarea', [
                                    'name' => 'message', 'value' => old('message'),
                                    'class' => 'form-control'
                                    ])
                                @endcomponent
                            @endcomponent
                        </div>
                        <div class="form-group text-right">
                            @component('components.submit', [
                                'class' => 'btn btn-outline-theme-1 btn-lg',
                                'id' => 'submit', 'name' => 'submit',
                                'value' => trans('general.send'),
                                'title' => trans('general.send_your_message')
                                ])
                            @endcomponent
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--End Form Area-->

    <!--Start Map Area-->
    <section class="probootstrap-section probootstrap-bg-white">
        <div class="container">
            <div class="row">
                <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2704.000272981015!2d-79.4449156846896!3d47.3338659791675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4d2641a19a32fd89%3A0x812185377cb867ac!2s18+A+Rue+Dollard%2C+Ville-Marie%2C+QC+J9V+1L2%2C+Canada!5e0!3m2!1sfr!2scm!4v1531600729639" frameborder="0" style="border:0" height="500" class="col-xs-12 map" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <!--End Map Area-->
@endsection

@push('landing.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush