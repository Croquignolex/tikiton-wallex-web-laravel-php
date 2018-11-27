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

    @component('components.app.new-transaction-modal', [
        'id' => 'new-transaction',
        'route' => locale_route('transactions.create')
    ])
    @endcomponent
@endsection

@push('layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('waves.min') }}" type="text/css">
    @stack('app.layout.style.page')
@endpush

@push('layout.script.page')
    <script src="{{ js_app_asset('waves.min') }}" type="text/javascript"></script>
    @stack('app.layout.script.page')
    <script type="text/javascript">
        (function ($) {
            "use strict";
            Waves.attach(".btn:not(.btn-icon):not(.btn-float)"), Waves.attach(".btn-icon, .btn-float", ["waves-circle", "waves-float"]), Waves.init();
        })(jQuery);
    </script>
@endpush