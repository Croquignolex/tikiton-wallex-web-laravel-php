@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.currencies')))

@section('breadcrumb.title', trans('general.currencies'))

@section('breadcrumb.message')
    <a href="{{ locale_route('currencies.index') }}">@lang('general.currencies')</a>
    ({{ $paginationTools->itemsNumber }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-dollar"></i>
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
                        @component('components.tips', ['title' => trans('general.currencies')])
                            @lang('tips.currencies')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.symbol')</th>
                                        <th class="text-theme-1">@lang('general.dev')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paginationTools->displayItems as $currency)
                                        <tr class="{{ $currency->is_current ? 'current' : '' }}">
                                            <td>{{ ($loop->index + 1) + ($paginationTools->itemsPerPage * ($paginationTools->currentPage - 1)) }}</td>
                                            <td><a href="{{ locale_route('currencies.show', [$currency]) }}" title="@lang('general.details')">{{ text_format($currency->name, 30) }}</a></td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td class="text-right">{{ $currency->format_devaluation }}</td>
                                            <td class="text-right">
                                                <a href="{{ locale_route('currencies.edit', [$currency]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                                                @if($currency->can_be_deleted)
                                                    <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-currency-{{ $currency->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                                                @endif
                                                @if(!$currency->is_current)
                                                    <a href="javascript: void(0);" class="text-success" data-toggle="modal" data-target="#activate-currency-{{ $currency->id }}" title="@lang('general.activate')"><i class="fa fa-check"></i></a>
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
                                        <th class="text-theme-1">@lang('general.symbol')</th>
                                        <th class="text-theme-1">@lang('general.dev')</th>
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

    @foreach($paginationTools->displayItems as $currency)
        @if($currency->can_be_deleted)
            @component('components.modal', [
                'title' => trans('general.delete_currency', ['name' => $currency->name]),
                'id' => 'delete-currency-' . $currency->id, 'color' => 'modal-danger',
                'action_route' => locale_route('currencies.destroy', [$currency])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
        @if(!$currency->is_current)
            @component('components.modal', [
                'title' => trans('general.activate_currency', ['name' => $currency->name]),
                'id' => 'activate-currency-' . $currency->id, 'color' => 'modal-success',
                'action_route' => locale_route('currencies.activate', [$currency]),
                'method' => 'PUT'
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection



