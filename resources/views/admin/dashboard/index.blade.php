@extends('layouts.admin.admin')

@section('admin.layout.title', admin_page_title(trans('general.general')))

@section('admin.layout.body')
@endsection

@push('app.layout.script.page')
    <script src="{{ js_app_asset('jquery.sparkline.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('Chart.min') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('dashboard') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('general-dashboard') }}" type="text/javascript"></script>
@endpush







