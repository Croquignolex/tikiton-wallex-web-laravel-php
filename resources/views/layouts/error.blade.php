@extends('layouts.app.layout')

@section('layout.title')
    @yield('error.layout.title')
@endsection

@section('layout.body')
    <div class="error-page-area">
        <div class="error-page-wrap">
            <i class="fa fa-ban"></i>
            <h1><span class="timer" data-from="0" data-to="@yield('error.code')"></span></h1>
            <p>@yield('error.title')</p>
            <p>@yield('error.body')</p>
            <a href="{{ locale_route('home') }}" class="btn waves-effect">@lang('general.home')</a>
        </div>
    </div>
@endsection

@push('layout.script.page')
    <script src="{{ js_app_asset('jquery.countTo') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.timer').countTo();
    </script>
@endpush
