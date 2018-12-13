@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.notifications')))

@section('breadcrumb.title', trans('general.notifications'))

@section('breadcrumb.message')
    <a href="{{ locale_route('notifications.index') }}">@lang('general.notifications')</a>
    ({{ $paginationTools->itemsNumber }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-bell-o"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currencies Area-->
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
                        @component('components.tips', ['title' => trans('general.notifications')])
                            @lang('tips.notifications')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.details')</th>
                                        <th class="text-theme-1">@lang('general.date')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paginationTools->displayItems as $notification)
                                        <tr>
                                            <td>{{ ($loop->index + 1) + ($paginationTools->itemsPerPage * ($paginationTools->currentPage - 1)) }}</td>
                                            <td>
                                                <span class="text-{{ $notification->color }}">
                                                    <i class="fa fa-{{ $notification->icon }}"></i>
                                                    {{ $notification->details }}
                                                </span>
                                            </td>
                                            <td class="text-right">{{ $notification->long_created_date }}</td>
                                            <td class="text-right">
                                                <a href="{{ $notification->url }}" class="text-warning" title="@lang('general.details')"><i class="fa fa-eye"></i></a>&nbsp;
                                                @if($notification->authorised)
                                                    <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-notification-{{ $notification->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
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
                                        <th class="text-theme-1">@lang('general.details')</th>
                                        <th class="text-theme-1">@lang('general.date')</th>
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
    <!--End Currencies Area-->

    @foreach($paginationTools->displayItems as $notification)
        @if($notification->authorised)
            @component('components.modal', [
                'title' => trans('general.delete_notification', ['name' => $notification->details]),
                'id' => 'delete-notification-' . $notification->id, 'color' => 'modal-danger',
                'action_route' => locale_route('notifications.destroy', [$notification])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection



