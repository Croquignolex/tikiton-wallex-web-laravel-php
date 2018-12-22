@extends('layouts.admin.breadcrumb')

@section('breadcrumb.admin.layout.title', page_title(trans('general.change_email')))

@section('breadcrumb.title', trans('general.change_email'))

@section('breadcrumb.message')
    <a href="{{ route('admin.account.index') }}">{{ text_format(\Illuminate\Support\Facades\Auth::user()->format_full_name, 50) }}</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.change_email')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-at"></i>
@endsection

@section('breadcrumb.admin.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right" id="form-validation">
                            @if(session()->has('popup.message'))
                                <div class="text-center">
                                    <div class="alert alert-{{ session('popup.type') }} alert-dismissable" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        {{ session('popup.message') }}
                                    </div>
                                </div>
                            @endif
                            <form action="" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
                                        <div class="form-group">
                                            @component('components.admin.label-input', ['name' => 'email'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'email', 'type' => 'email',
                                                       'class' => 'form-control', 'value' => old('email') ?? $user->email,
                                                       'placeholder'  => trans('general.email') . '*'
                                                    ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_email')">
                                                <i class="fa fa-repeat"></i>
                                                @lang('general.update')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Setting Area-->
@endsection

@push('breadcrumb.admin.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush




