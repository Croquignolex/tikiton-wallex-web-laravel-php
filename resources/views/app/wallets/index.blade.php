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
    <!--Start Wallets Area-->
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
                        @component('components.tips', ['title' => trans('general.accounts')])
                            @lang('tips.accounts')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            @forelse($paginationTools->displayItems as $wallet)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="white-container">
                                        <div class="contact-hd sm-form-hd text-center" style="background-color:{{ $wallet->color }};">
                                            <div class="account-header">
                                                <h5 class="text-uppercase">
                                                    <a href="{{ locale_route('wallets.show', [$wallet]) }}" title="@lang('general.details')">
                                                        {{ text_format($wallet->format_name, 20) }}
                                                    </a>
                                                </h5>
                                                <div class="text-right">
                                                    {{ $wallet->format_balance }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <small class="text-{{ $wallet->format_stated->color }}">
                                                {{ $wallet->format_stated->text }}
                                            </small>&nbsp;
                                            <a href="{{ locale_route('wallets.edit', [$wallet]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                                            @if($wallet->can_delete)
                                                <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-wallet-{{ $wallet->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="white-container">
                                        <div class="text-center">
                                            <div class="alert alert-info text-center" role="alert">
                                                @lang('general.no_data')
                                            </div>
                                        </div>
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
    <!--End Wallets Area-->

    @foreach($paginationTools->displayItems as $wallet)
        @if($wallet->can_delete)
            @component('components.modal', [
                'title' => trans('general.delete_account', ['name' => $wallet->name]),
                'id' => 'delete-wallet-' . $wallet->id, 'color' => 'modal-danger',
                'action_route' => locale_route('wallets.destroy', [$wallet])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection



