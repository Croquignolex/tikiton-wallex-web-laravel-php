@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.settings')))

@section('breadcrumb.title', trans('general.settings'))

@section('breadcrumb.message')
    <a href="{{ locale_route('settings.index') }}">@lang('general.settings')</a>
    ({{ $paginationTools->itemsNumber }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-cogs"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Settings Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        @component('components.pagination',
                            ['paginationTools' => $paginationTools])
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.settings')])
                            @lang('tips.settings')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.tips')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paginationTools->displayItems as $setting)
                                        <tr class="{{ $setting->is_current ? 'current' : '' }}">
                                            <td>{{ ($loop->index + 1) + ($paginationTools->itemsPerPage * ($paginationTools->currentPage - 1)) }}</td>
                                            <td>
                                                <span class="text-right" data-content="{{ $setting->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                    {{ $setting->table_name }}
                                                </span>
                                            <td>
                                                <small class="text-{{ $setting->format_tips->color }}">
                                                    {{ $setting->format_tips->text }}
                                                </small>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ locale_route('settings.show', [$setting]) }}" class="text-theme-1" title="@lang('general.details')"><i class="fa fa-eye "></i></a>&nbsp;
                                                <a href="{{ locale_route('settings.edit', [$setting]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>
                                                @if($setting->can_be_deleted)
                                                    &nbsp;<a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-setting-{{ $setting->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>&nbsp;
                                                    <a href="javascript: void(0);" class="text-success" data-toggle="modal" data-target="#activate-setting-{{ $setting->id }}" title="@lang('general.activate')"><i class="fa fa-check"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="4" class="text-center">
                                            <div class="text-center">
                                                <div class="alert alert-info text-center" role="alert">
                                                    @lang('general.no_data')
                                                </div>
                                            </div>
                                        </td>
                                    @endforelse
                                </tbody>
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.tips')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.pagination',
                            ['paginationTools' => $paginationTools])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Settings Area-->

    @foreach($paginationTools->displayItems as $setting)
        @if($setting->can_be_deleted)
            @component('components.modal', [
                'title' => trans('general.delete_setting', ['name' => $setting->name]),
                'id' => 'delete-setting-' . $setting->id, 'color' => 'modal-danger',
                'action_route' => locale_route('settings.destroy', [$setting])
                ])
                @lang('general.cfm_action')?
            @endcomponent
            @component('components.modal', [
                'title' => trans('general.activate_setting', ['name' => $setting->name]),
                'id' => 'activate-setting-' . $setting->id, 'color' => 'modal-success',
                'action_route' => locale_route('settings.activate', [$setting]),
                'method' => 'PUT'
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection



