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
                            <a href="{{ locale_route('settings.edit', [$setting]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                            @if($setting->can_be_deleted)
                                <a href="javascript: void(0);" class="text-danger hand-cursor" data-toggle="modal" data-target="#delete-setting" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>&nbsp;
                                <a href="javascript: void(0);" class="text-success hand-cursor" data-toggle="modal" data-target="#activate-setting" title="@lang('general.activate')"><i class="fa fa-check"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <div class="contact-hd sm-form-hd text-center">
                                <div class="account-header">
                                    <strong class="text-uppercase">{{ $setting->name }}</strong>
                                </div>
                            </div>
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#description">@lang('general.description')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="details" class="tab-pane fade in active">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.tips') :</strong>
                                                    <small class="text-{{ $setting->format_tips->color }}">
                                                        {{ $setting->format_tips->text }}
                                                    </small>
                                                    @if($setting->tips)
                                                        <a href="javascript: void(0);" class="text-warning" data-toggle="modal" data-target="#disable-tips"
                                                           title="@lang('general.disable')"><i class="fa fa-times"></i></a>
                                                    @else
                                                        <a href="javascript: void(0);" class="text-info" data-toggle="modal" data-target="#enable-tips"
                                                           title="@lang('general.enable')"><i class="fa fa-check"></i></a>
                                                    @endif
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $setting->long_created_date }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $setting->long_updated_date }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade overflow">
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

    @if($setting->can_be_deleted)
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



