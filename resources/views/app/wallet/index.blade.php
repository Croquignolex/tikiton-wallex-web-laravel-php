@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.accounts')))

@section('breadcrumb.title', trans('general.accounts'))

@section('breadcrumb.message')
    <a href="{{ locale_route('wallets.index') }}">@lang('general.accounts')</a>
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-credit-card"></i>
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
                        <div class="row">
                            @forelse($paginationTools->displayItems as $account)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="white-container">
                                        <div class="contact-hd sm-form-hd text-center" style="background-color:{{ $account->color }};">
                                            <div class="account-header">
                                                <strong class="text-uppercase">{{ $account->format_name }}</strong>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <small class="text-{{ $account->format_stated->color }}">
                                                <i class="{{ $account->format_stated->icon }}"></i>
                                                {{ $account->format_stated->text }}
                                            </small>
                                        </div>
                                        <div class="widget-tabs-list">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#details{{ $account->id }}">@lang('general.details')</a></li>
                                                <li><a data-toggle="tab" href="#transactions{{ $account->id }}">@lang('general.movements')</a></li>
                                                <li><a data-toggle="tab" href="#description{{ $account->id }}">@lang('general.description')</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="details{{ $account->id }}" class="tab-pane fade in active">
                                                    <div class="tab-ctn">
                                                        <ul class="tab-ctn-list text-right">
                                                            <li><strong><h3 class="text-success">{{ currency($account->format_balance) }}</h3></strong></li>
                                                            <li><small><i>{{ currency($account->format_threshold) }}</i></small></li>
                                                        </ul>
                                                        <div>
                                                            <button class="btn btn-warning" type="button">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                            <button class="btn btn-default" type="button">
                                                                <i class="fa fa-exchange"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="transactions{{ $account->id }}" class="tab-pane fade">
                                                    <div class="alert alert-info text-center" role="alert">
                                                        @lang('general.no_data')
                                                    </div>
                                                </div>
                                                <div id="description{{ $account->id }}" class="tab-pane fade">
                                                    <div class="tab-ctn">
                                                        <p class="multi-line-text">{{ $account->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center">
                                    <div class="alert alert-info text-center" role="alert">
                                        @lang('general.no_data')
                                    </div>
                                </div>
                            @endforelse
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



