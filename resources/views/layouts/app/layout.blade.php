@extends('layouts.master')

@section('title')
    @yield('layout.title')
@endsection

@section('body')
    @yield('layout.body')
@endsection

@push('style.plugin')
    <!--Start CSS Plugins Area-->
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('meanmenu.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('normalize') }}" type="text/css">
    <!--End CSS Plugins Area-->
@endpush

@push('style.page')
    <!--Start Page Style Area-->
    @stack('layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('style') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('responsive') }}" type="text/css">
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--End Page Style Area-->
@endpush

@push('script.plugin')
    <!--Start JS Plugins Area-->
    <script src="{{ js_app_asset('jquery.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap.min') }}" type="text/javascript"></script>
    <!--Start JS Plugins Area-->
@endpush

@push('script.page')
    <!--Start Page Scripts Area-->
    <script src="{{ js_app_asset('wow.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('jquery.meanmenu') }}" type="text/javascript"></script>
    @stack('layout.script.page')
    <script src="{{ js_app_asset('script') }}" type="text/javascript"></script>
    <!--End Page Scripts Area-->
@endpush