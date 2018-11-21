@extends('layouts.app.layout')

@section('layout.title')
    @yield('error.layout.title')
@endsection

@section('layout.body')
    <div class="error-page-area">
        <div class="error-page-wrap">
            <i class="fa fa-ban"></i>
            <h1><span class="counter">@yield('error.code')</span></h1>
            <p>@yield('error.title')</p>
            <p>@yield('error.body')</p>
            <a href="{{ locale_route('home') }}" class="btn waves-effect">@lang('general.home')</a>
        </div>
    </div>
@endsection