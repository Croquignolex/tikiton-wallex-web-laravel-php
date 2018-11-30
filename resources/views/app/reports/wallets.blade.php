@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.accounts_report')))

@section('breadcrumb.title', trans('general.accounts_report'))

@section('breadcrumb.message')
    <a href="{{ locale_route('wallets.index') }}">@lang('general.accounts')</a>
    ({{ $wallets->count() }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-calendar"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Wallets Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.reports')])
                            @lang('tips.accounts_report')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-1">#</th>
                                        <th class="text-theme-1">@lang('general.name')</th>
                                        <th class="text-theme-1">@lang('general.amount')</th>
                                        <th class="text-theme-1">@lang('general.amount') ({{ $current_currency->symbol }})</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wallets as $wallet)
                                        <tr class="{{ !$wallet->is_stated ? 'current' : '' }}">
                                            <td>{{ ($loop->index + 1) }}</td>
                                            <td>
                                                <a href="{{ locale_route('wallets.show', [$wallet]) }}" title="@lang('general.details')"
                                                   style="color:{{ $wallet->color }};">
                                                    {{ text_format($wallet->format_name, 20) }}
                                                </a>
                                            </td>
                                            <td class="text-right">{{ $wallet->format_balance }}</td>
                                            <td class="text-right">{{ $wallet->format_current_currency_balance }}</td>
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
                                        <th colspan="3" class="text-theme-1">@lang('general.total')</th>
                                        <th class="text-theme-1 text-right">{{ $total }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Wallets Area-->
@endsection



