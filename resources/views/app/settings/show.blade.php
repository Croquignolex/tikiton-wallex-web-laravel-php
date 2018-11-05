@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.setting_details')))

@section('breadcrumb.title', trans('general.setting_details'))

@section('breadcrumb.message')
    <a href="{{ locale_route('settings.index') }}">@lang('general.settings')</a>
    <i class="fa fa-caret-right"></i>
    @lang('general.setting_details')
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-cogs"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Setting Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.settings')])
                            @lang('tips.settings_details')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container text-right">
                            <a href="{{ locale_route('settings.edit', [$setting]) }}" class="btn btn-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>
                            @if($setting->is_current)
                                <button type="button" class="btn btn-danger disabled" title="@lang('general.c_n_d_setting')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-setting" title="@lang('general.delete')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            @endif
                            @if($setting->is_current)
                                <button type="button" class="btn btn-success disabled" title="@lang('general.c_n_a_setting')">
                                    <i class="fa fa-check"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#activate-setting" title="@lang('general.activate')">
                                    <i class="fa fa-check"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header">
                                    <strong class="text-uppercase">{{ $setting->name }}</strong>
                                </div>
                            </div>
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tips">@lang('general.tips')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tips" class="tab-pane fade in active">
                                        <div class="tab-ctn">
                                            @if($setting->tips)
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#disable-tips">
                                                    <i class="fa fa-times"></i>
                                                    @lang('general.disable')
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#enable-tips">
                                                    <i class="fa fa-check"></i>
                                                    @lang('general.enable')
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade">
                                        <div class="tab-ctn">
                                            <p class="multi-line-text">{{ $setting->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Setting Area-->

    @if(!$setting->is_current)
        @component('components.modal', [
            'title' => trans('general.delete_setting', ['name' => $setting->name]),
            'id' => 'delete-setting', 'color' => 'modal-danger',
            'action_route' => locale_route('settings.destroy', [$setting])
            ])
            @lang('general.cfm_action')?
        @endcomponent

        @component('components.modal', [
            'title' => trans('general.activate_setting', ['name' => $setting->name]),
            'id' => 'activate-setting', 'color' => 'modal-success', 'method' => 'PUT',
            'action_route' => locale_route('settings.activate', [$setting]),
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif

    @if($setting->tips)
        @component('components.modal', [
            'title' => trans('general.disable_tips', ['name' => $setting->name]),
            'id' => 'disable-tips', 'color' => 'modal-warning', 'method' => 'PUT',
            'action_route' => locale_route('settings.tips.disable', [$setting])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @else
        @component('components.modal', [
            'title' => trans('general.enable_tips', ['name' => $setting->name]),
            'id' => 'enable-tips', 'color' => 'modal-info', 'method' => 'PUT',
            'action_route' => locale_route('settings.tips.enable', [$setting])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif
@endsection



