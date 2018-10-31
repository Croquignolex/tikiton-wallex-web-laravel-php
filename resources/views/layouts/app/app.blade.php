@extends('layouts.app.layout')

@section('layout.title')
    @yield('app.layout.title')
@endsection

@section('layout.body')
    @include('partials.app.header')
    @include('partials.app.mobile_menu')
    @include('partials.app.menu')
    @yield('app.layout.body')
    @include('partials.app.footer')
@endsection

@push('layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('meanmenu.min') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('normalize') }}" type="text/css">
    <link rel="stylesheet" href="{{ css_app_asset('waves.min') }}" type="text/css">
    @stack('app.layout.style.page')
    <script src="{{ js_app_asset('modernizr-2.8.3.min') }}" type="text/javascript"></script>
@endpush

@push('layout.script.page')
    <script src="{{ js_app_asset('waves.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('wave-active') }}" type="text/javascript"></script>
    @stack('app.layout.script.page')
@endpush