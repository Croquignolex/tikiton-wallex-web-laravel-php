@extends('layouts.landing')

@section('landing.layout.title', page_title(trans('general.privacy_policy')))

@section('page_name', trans('general.privacy_policy'))

@section('page_desc', trans('general.privacy_policy'))

@section('page_icon')
    <i class="fa fa-lock"></i>
@endsection

@section('landing.layout.body')
    <!--Start Our Policy Area-->
    <section class="probootstrap-section probootstrap-bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.our_policy')</h2>
                    <p class="text-justify">@lang('general.our_policy_desc', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Our Policy Area-->

    <!--Start Information We Collect Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.information_we_collect')</h2>
                    <p class="text-justify">@lang('general.information_we_collect_desc', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Information We Collect Area-->

    <!--Start Security Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.security')</h2>
                    <p class="text-justify">@lang('general.security_desc', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Security Area-->

    <!--Start Access To Information Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12  section-heading probootstrap-animate">
                    <h2 class="text-uppercase">@lang('general.access_to_information')</h2>
                    <p class="text-justify">@lang('general.access_to_information_desc', ['app' => config('app.name')]).</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Access To Information Area-->
@endsection