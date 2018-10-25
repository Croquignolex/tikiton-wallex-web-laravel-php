@extends('layouts.app.layout')

@section('layout.title')
    @yield('app.layout.title')
@endsection

@section('body')
    <!--Start Header Area-->
    <!--End Header Area-->

    <!--Start Sidebar Area-->
    <!--End Sidebar Area-->

    @yield('layout.body')

    <!--Start Footer Area-->
    <!--End Footer Area-->
    @include('partials.app.footer')
@endsection

@push('layout.style.page')
    @stack('app.layout.style.page')
@endpush

@push('layout.script.page')
    @stack('app.layout.script.page')
@endpush