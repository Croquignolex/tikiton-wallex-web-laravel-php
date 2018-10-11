@extends('layouts.landing')

@section('landing.layout.title', page_title(trans('general.terms_of_uses')))

@section('page_name', trans('general.terms_of_uses'))

@section('page_desc', trans('general.terms_of_uses'))

@section('page_icon')
    <i class="fa fa-handshake-o"></i>
@endsection

@section('landing.layout.body')
    <!--Start Terms And Conditions Area-->
    <section class="probootstrap-section probootstrap-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.terms_and_conditions')</h2>
                    <p class="text-justify">@lang('general.terms_and_conditions_desc_1', ['app' => config('app.name')]).</p>
                    <p class="text-justify">@lang('general.terms_and_conditions_desc_2').</p>
                    <p class="text-justify">@lang('general.terms_and_conditions_desc_3', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Terms And Conditions Area-->

    <!--Start Site Uses Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.site_uses')</h2>
                    <p class="text-justify">@lang('general.site_uses_desc_1').</p>
                    <p class="text-justify">@lang('general.site_uses_desc_2', ['app' => config('app.name'), 'company' => config('company.name')]).</p>
                    <p class="text-justify">@lang('general.site_uses_desc_3', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Site Uses Area-->

    <!--Start Liability Limitation Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.liability_limitation')</h2>
                    <p class="text-justify">@lang('general.liability_limitation_desc_1', ['app' => config('app.name')]).</p>
                    <p class="text-justify">@lang('general.liability_limitation_desc_2', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Liability Limitation Area-->

    <!--Start Indemnification Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.indemnification')</h2>
                    <p class="text-justify">@lang('general.indemnification_desc', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Indemnification Area-->
@endsection