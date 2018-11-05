@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.currencies')))

@section('breadcrumb.title', trans('general.currencies'))

@section('breadcrumb.message')
    <a href="{{ locale_route('currencies.index') }}">@lang('general.currencies')</a>
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-dollar"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Breadcrumb Area-->
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
                            @lang('general.no_data')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.description')</th>
                                        <th class="text-theme-1">@lang('general.symbol')</th>
                                        <th class="text-theme-1">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paginationTools->displayItems as $currency)
                                        <tr>
                                            <td>{{ ($loop->index + 1) + ($paginationTools->itemsPerPage * ($paginationTools->currentPage - 1)) }}</td>
                                            <td>{{ $currency->name }}</td>
                                            <td>{{ $currency->description }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>Ducky</td>
                                        </tr>
                                    @empty
                                        <td colspan="5" class="text-center">
                                            <div class="text-center">
                                                <div class="alert alert-info text-center" role="alert">
                                                    @lang('general.no_data')
                                                </div>
                                            </div>
                                        </td>
                                </tbody>
                                @endforelse
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.description')</th>
                                        <th class="text-theme-1">@lang('general.symbol')</th>
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
    <!--End Accounts Area-->
@endsection



