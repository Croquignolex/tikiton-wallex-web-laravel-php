@extends('layouts.admin.breadcrumb')

@section('breadcrumb.admin.layout.title', admin_page_title('Nouvel utilisateur'))

@section('breadcrumb.title', 'Nouvel utilisateur')

@section('breadcrumb.message')
    <a href="{{ route('admin.users.index') }}">Utilisateurs</a>
    <i class="fa fa-caret-right"></i>
    Nouvel utilisateur
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-users"></i>
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
                            <form action="{{ route('admin.users.store') }}" method="POST" @submit="validateFormElements">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.admin.label-input', ['name' => 'first_name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'first_name',
                                                       'class' => 'form-control', 'value' => old('first_name'),
                                                       'placeholder'  => trans('general.first_name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.admin.label-input', ['name' => 'last_name'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'last_name',
                                                       'class' => 'form-control', 'value' => old('last_name'),
                                                       'placeholder'  => trans('general.last_name') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>
                                        <div class="form-group">
                                            @component('components.admin.label-input', ['name' => 'email'])
                                                <div class="nk-int-st">
                                                    @component('components.input', [
                                                       'name' => 'email', 'type' => 'email',
                                                       'class' => 'form-control', 'value' => old('email'),
                                                       'placeholder'  => trans('general.email') . '*'
                                                       ])
                                                    @endcomponent
                                                </div>
                                            @endcomponent
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            @component('components.admin.label-input', ['name' => 'password'])
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
                                            @component('components.admin.label-input', ['name' => 'pwd_cfm'])
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
                                            <button type="submit" class="btn btn-success waves-effect" title="Nouvel utilisateur">
                                                <i class="fa fa-plus"></i>
                                                @lang('general.add')
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




