@extends('layouts.master')

@section('title')
    @yield('layout.title')
@endsection

@section('body')
    <!--[if lt IE 8]><p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->
    @yield('layout.body')
@endsection

@push('style.plugin')
    <!--Start CSS Plugins Area-->
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('owl.carousel') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('owl.theme') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('owl.transitions') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('jquery.mCustomScrollbar.min') }}" type="text/css">
    <!--End CSS Plugins Area-->
@endpush

@push('style.page')
    <!--Start Page Style Area-->
    <link rel="stylesheet" href="{{ css_app_asset('style') }}" type="text/css">
    @stack('layout.style.page')
    <!--End Page Style Area-->
@endpush

@push('script.plugin')
    <!--Start JS Plugins Area-->
    <script src="{{ js_app_asset('jquery.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('wow.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('jquery-price-slider') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('owl.carousel.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('jquery.meanmenu') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('jquery.mCustomScrollbar.concat.min') }}" type="text/javascript"></script>
    <!--Start JS Plugins Area-->
@endpush

@push('script.page')
    <!--Start Page Scripts Area-->
    <script src="{{ js_app_asset('script') }}" type="text/javascript"></script>
    @stack('layout.script.page')
    <!--End Page Scripts Area-->
@endpush