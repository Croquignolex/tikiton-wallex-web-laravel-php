@extends('layouts.layout')

@section('layout.title')
    @yield('landing.layout.title')
@endsection

@section('layout.body')
    <!--Start Page Name Area-->
    <section class="probootstrap-hero probootstrap-xs-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-8 text-left probootstrap-hero-text probootstrap-animate" data-animate-effect="fadeIn">
                    <h1 class="text-theme-1">@yield('page_icon') @yield('page_name')</h1>
                    <p>@yield('page_desc')</p>
                </div>
            </div>
        </div>
    </section>
    <!--End Page Name Area-->
    @yield('landing.layout.body')
@endsection