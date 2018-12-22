@extends('layouts.admin.layout')

@section('layout.title')
    @yield('admin.layout.title')
@endsection

@section('layout.body')
    @include('partials.admin.header')
    @include('partials.admin.mobile_menu')
    @include('partials.admin.menu')
    @yield('admin.layout.body')
    @include('partials.app.footer')
@endsection

@push('layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('waves.min') }}" type="text/css">
    @stack('admin.layout.style.page')
@endpush

@push('layout.script.page')
    <script src="{{ js_app_asset('waves.min') }}" type="text/javascript"></script>
    @stack('admin.layout.script.page')
    <script type="text/javascript">
        (function ($) {
            "use strict";
            Waves.attach(".btn:not(.btn-icon):not(.btn-float)"), Waves.attach(".btn-icon, .btn-float", ["waves-circle", "waves-float"]), Waves.init();
        })(jQuery);
    </script>
@endpush