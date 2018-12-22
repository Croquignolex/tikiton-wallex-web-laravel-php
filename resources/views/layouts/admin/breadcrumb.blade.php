@extends('layouts.admin.admin')

@section('admin.layout.title')
    @yield('breadcrumb.admin.layout.title')
@endsection

@section('admin.layout.body')
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
                                        <h2 class="text-theme-2 text-uppercase">@yield('breadcrumb.title')</h2>
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

    @yield('breadcrumb.admin.layout.body')
@endsection

@push('admin.layout.style.page')
    @stack('breadcrumb.admin.layout.style.page')
@endpush

@push('admin.layout.script.page')
    @stack('breadcrumb.admin.layout.script.page')
@endpush