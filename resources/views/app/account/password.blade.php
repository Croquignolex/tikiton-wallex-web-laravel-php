@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.change_password')))

@section('breadcrumb.title', trans('general.change_password'))

@section('breadcrumb.message')
    <a href="{{ locale_route('account.index') }}">{{ text_format(\Illuminate\Support\Facades\Auth::user()->format_full_name, 50) }}</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.change_password')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-lock"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.profile')])
                            @lang('tips.account_password')
                        @endcomponent
                    </div>
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
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'old_password'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'old_password', 'type' => 'password', 'class' => 'form-control',
                                                       'placeholder'  => trans('general.old_password') . '*', 'value' => old('old_password'),
                                                       'min_length' => 6
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'password'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'password', 'type' => 'password', 'class' => 'form-control',
                                                       'placeholder'  => trans('general.password') . '*', 'value' => old('password'),
                                                       'min_length' => 6
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.app.label-input', ['name' => 'pwd_cfm'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'password_confirmation', 'type' => 'password', 'class' => 'form-control',
                                                       'placeholder'  => trans('general.pwd_cfm') . '*', 'value' => old('password_confirmation'),
                                                       'min_length' => 6
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success waves-effect" title="@lang('general.update_password')">
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

@push('breadcrumb.app.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush




