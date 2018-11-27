@inject('languageService', 'App\Services\LanguageService')

@extends('layouts.master')

@section('title')
    @yield('layout.title')
@endsection

@section('body')
    @include('partials.landing.header')
    @yield('layout.body')
    @include('partials.landing.contact_band')
    @include('partials.landing.footer')
@endsection

@push('style.plugin')
    @include('partials.landing.site_info')

    <!--Start CSS Plugins Area-->
    <link rel="stylesheet" href="{{ css_asset('bootstrap.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('animsition.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_asset('aos') }}" type="text/css">
    <!--End CSS Plugins Area-->
@endpush

@push('style.page')
    <!--Start Page Style Area-->
    <link rel="stylesheet" href="{{ css_asset('style') }}" type="text/css">
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--End Page Style Area-->
@endpush

@push('script.plugin')
    <!--Start JS Plugins Area-->
    <script src="{{ js_asset('jquery.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('bootstrap.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('animsition.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('aos') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.appear') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.stellar.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('jquery.waypoints.min') }}" type="text/javascript"></script>
    <script src="{{ js_asset('respond.min') }}" type="text/javascript"></script>
    <!--End JS Plugins Area-->
@endpush

@push('script.page')
    <!--Start Page Scripts Area-->
    <script src="{{ js_asset('script') }}" type="text/javascript"></script>
    @stack('layout.script.page')
    <!--End Page Scripts Area-->
@endpush