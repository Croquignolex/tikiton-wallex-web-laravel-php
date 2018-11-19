@extends('layouts.app.app')

@section('app.layout.title')
    @yield('breadcrumb.app.layout.title')
@endsection

@section('app.layout.body')
    <!--Start Breadcrumb Area-->
    <div class="breadcomb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-list">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-icon">
                                        @yield('breadcrumb.icon')
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2 class="text-theme-1 text-uppercase">@yield('breadcrumb.title')</h2>
                                        <p>@yield('breadcrumb.message')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Breadcrumb Area-->

    @yield('breadcrumb.app.layout.body')
@endsection

@push('app.layout.style.page')
    @stack('breadcrumb.app.layout.style.page')
@endpush

@push('app.layout.script.page')
    @stack('breadcrumb.app.layout.script.page')
@endpush