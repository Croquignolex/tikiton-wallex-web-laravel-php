@extends('layouts.landing')

@section('landing.layout.title', page_title(trans('general.register')))

@section('page_name', trans('general.register'))

@section('page_desc', trans('auth.new_account'))

@section('page_icon')
    <i class="fa fa-user-plus"></i>
@endsection

@section('landing.layout.body')
    <!--Start FAQs Area-->
    <section class="probootstrap-section probootstrap-bg-white probootstrap-zindex-above-showcase">
        <div class="container">
             <div class="row">
                 @if(session()->has('notification.message'))
                     <div class="text-center col-sm-10 col-sm-offset-1">
                         <div class="alert alert-{{ session('notification.type') }} alert-dismissable" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                             {{ session('notification.message') }}
                         </div>
                     </div>
                 @endif
                 <form action="" method="POST" class="probootstrap-form" @submit="validateFormElements">
                     {{ csrf_field() }}
                     <div class="col-md-6 probootstrap-animate" data-animate-effect="fadeIn">
                         <div class="form-group">
                             @component('components.label-input', [
                                     'name' => 'first_name', 'label' => trans('general.first_name'),
                                     'star' => '*'
                                     ])
                                 @component('components.input', [
                                     'name' => 'first_name', 'attribute' => 'autofocus',
                                     'class' => 'form-control', 'value' => old('first_name')
                                     ])
                                 @endcomponent
                             @endcomponent
                         </div>
                         <div class="form-group">
                             @component('components.label-input', [
                                     'name' => 'last_name', 'label' => trans('general.last_name'),
                                     'star' => '*'
                                     ])
                                 @component('components.input', [
                                     'name' => 'last_name', 'value' => old('last_name'),
                                     'class' => 'form-control'
                                     ])
                                 @endcomponent
                             @endcomponent
                         </div>
                         <div class="form-group">
                             @component('components.label-input', [
                                     'name' => 'email', 'label' => trans('general.email'),
                                     'star' => '*'
                                     ])
                                 @component('components.input', [
                                     'type' => 'email', 'name' => 'email',
                                     'class' => 'form-control', 'value' => old('email')
                                     ])
                                 @endcomponent
                             @endcomponent
                         </div>
                     </div>
                     <div class="col-md-6 probootstrap-animate" data-animate-effect="fadeIn">
                         <div class="form-group">
                             @component('components.label-input', [
                                     'name' => 'password', 'label' => trans('general.password'),
                                     'star' => '*'
                                     ])
                                 @component('components.input', [
                                     'type' => 'password', 'name' => 'password', 'min_length' => 6,
                                     'value' => old('password'), 'class' => 'form-control'
                                     ])
                                 @endcomponent
                             @endcomponent
                         </div>
                         <div class="form-group">
                             @component('components.label-input', [
                                     'name' => 'password_confirmation', 'star' => '*',
                                     'label' => trans('general.pwd_cfm')
                                     ])
                                 @component('components.input', [
                                     'type' => 'password', 'name' => 'password_confirmation', 'min_length' => 6,
                                     'value' => old('password_confirmation'), 'class' => 'form-control'
                                     ])
                                 @endcomponent
                             @endcomponent
                         </div>
                         <div class="form-group text-right">
                             @component('components.submit', [
                                 'class' => 'btn btn-outline-theme-1 btn-lg',
                                 'id' => 'submit', 'name' => 'submit',
                                 'value' => trans('auth.register'),
                                 'title' => trans('auth.new_account')
                                 ])
                             @endcomponent
                         </div>
                         <div class="form-group text-right">
                             <a href="{{ locale_route('login') }}">@lang('auth.login_sign_upped')</a>
                         </div>
                     </div>
                 </form>
             </div>
        </div>
    </section>
    <!--End FAQs Area-->
@endsection

@push('landing.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
@endpush