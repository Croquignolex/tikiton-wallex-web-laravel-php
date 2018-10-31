@extends('layouts.landing.layout')

@section('layout.title')
    @yield('landing.layout.title')
@endsection

@section('layout.body')
    @include('partials.landing.page_name')
    @yield('landing.layout.body')
@endsection

@push('layout.script.page')
    @stack('landing.layout.script.page')
@endpush