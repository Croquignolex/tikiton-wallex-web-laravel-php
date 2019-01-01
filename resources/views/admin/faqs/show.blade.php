@extends('layouts.admin.breadcrumb')

@section('breadcrumb.admin.layout.title', admin_page_title('Détail du FAQ'))

@section('breadcrumb.title', 'Détail du FAQ')

@section('breadcrumb.message')
    <a href="{{ route('admin.faqs.index') }}">FAQs</a>
    <i class="fa fa-caret-right"></i>
    Détail du FAQ
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-question-circle"></i>
@endsection

@section('breadcrumb.admin.layout.body')
    <!--Start Currency Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container">
                            <div class="widget-tabs-list">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#details">@lang('general.details')</a></li>
                                    <li><a data-toggle="tab" href="#question">@lang('general.question')</a></li>
                                    <li><a data-toggle="tab" href="#answer">@lang('general.answer')</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="details" class="tab-pane fade in active">
                                        <div class="tab-ctn">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    @if($user->is_confirmed)
                                                        <span class="text-success">Confirmé</span>
                                                        <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#disable-user"
                                                           title="@lang('general.disable')"><i class="fa fa-times"></i></a>
                                                    @else
                                                        <span class="text-danger">Bloqué</span>
                                                        <a href="javascript: void(0);" class="text-success" data-toggle="modal" data-target="#enable-user"
                                                           title="@lang('general.enable')"><i class="fa fa-check"></i></a>
                                                    @endif
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.email') :</strong>
                                                    {{ $user->email }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.first_name') :</strong>
                                                    {{ $user->format_first_name }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.last_name') :</strong>
                                                    {{ $user->format_last_name }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.address') :</strong>
                                                    {{ $user->address }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.post_code') :</strong>
                                                    {{ $user->post_code }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.phone') :</strong>
                                                    {{ $user->phone }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.country') :</strong>
                                                    {{ $user->country }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.city') :</strong>
                                                    {{ $user->city }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.profession') :</strong>
                                                    {{ $user->profession }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.creation_date') :</strong>
                                                    {{ $user->long_created_date }}
                                                </li>
                                                <li>
                                                    <i class="fa fa-caret-right"></i>
                                                    <strong>@lang('general.last_update') :</strong>
                                                    {{ $user->long_updated_date }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="accounts" class="tab-pane fade">
                                        <div class="tab-ctn table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-uppercase">
                                                        <th class="text-theme-2">#</th>
                                                        <th class="text-theme-2">@lang('general.name')</th>
                                                        <th class="text-theme-2">@lang('general.currency')</th>
                                                        <th class="text-theme-2">@lang('general.balance')</th>
                                                        <th class="text-theme-2">@lang('general.threshold')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($user->wallets as $wallet)
                                                        <tr>
                                                            <td>
                                                                <span data-title="Description" data-content="{{ $wallet->description }}"
                                                                      data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                                    {{ $loop->index + 1 }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-right" data-content="{{ $wallet->popover_name }}" data-trigger="hover"
                                                                      data-toggle="popover" data-placement="bottom" style="color:{{ $wallet->color }};">
                                                                    {{ $wallet->table_name }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-right" data-content="{{ $wallet->currency->popover_name }}"
                                                                      data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                                    {{ $wallet->currency->table_name }} ({{ $wallet->currency->symbol }})
                                                                </span>
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="text-success">{{ $wallet->format_balance }}</span>
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="text-danger">{{ $wallet->format_threshold }}</span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <td colspan="5" class="text-center">
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
                                                        <th class="text-theme-2">#</th>
                                                        <th class="text-theme-2">@lang('general.name')</th>
                                                        <th class="text-theme-2">@lang('general.currency')</th>
                                                        <th class="text-theme-2">@lang('general.balance')</th>
                                                        <th class="text-theme-2">@lang('general.threshold')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="categories" class="tab-pane fade">
                                        <div class="tab-ctn table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-uppercase">
                                                        <th class="text-theme-2">#</th>
                                                        <th class="text-theme-2">@lang('general.name')</th>
                                                        <th class="text-theme-2">@lang('general.icon')</th>
                                                        <th class="text-theme-2">@lang('general.type')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($user->categories as $category)
                                                        <tr>
                                                            <td>
                                                                <span data-title="Description" data-content="{{ $category->description }}"
                                                                      data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                                    {{ $loop->index + 1 }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-right" data-content="{{ $category->popover_name }}" data-trigger="hover"
                                                                      data-toggle="popover" data-placement="bottom">
                                                                    {{ $category->table_name }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center"><i class="fa fa-{{ $category->icon }}" style="color:{{ $category->color }};"></i></td>
                                                            <td class="text-center">
                                                                <i class="fa fa-{{ $category->format_type->icon }} {{ $category->format_type->color }}"></i>
                                                                {{ $category->format_type->text }}
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
                                                        <th class="text-theme-2">#</th>
                                                        <th class="text-theme-2">@lang('general.name')</th>
                                                        <th class="text-theme-2">@lang('general.icon')</th>
                                                        <th class="text-theme-2">@lang('general.type')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="currencies" class="tab-pane fade">
                                        <div class="tab-ctn table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-uppercase">
                                                        <th class="text-theme-2">#</th>
                                                        <th class="text-theme-2">@lang('general.name')</th>
                                                        <th class="text-theme-2">@lang('general.symbol')</th>
                                                        <th class="text-theme-2">@lang('general.devaluation')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($user->currencies as $currency)
                                                        <tr>
                                                            <td>
                                                                <span data-title="Description" data-content="{{ $currency->description }}"
                                                                      data-trigger="hover" data-toggle="popover" data-placement="bottom">
                                                                    {{ $loop->index + 1 }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="text-right" data-content="{{ $currency->popover_name }}" data-trigger="hover"
                                                                      data-toggle="popover" data-placement="bottom">
                                                                    {{ $currency->table_name }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $currency->symbol }}
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="text-success">{{ $currency->format_devaluation }}</span>
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
                                                        <th class="text-theme-2">#</th>
                                                        <th class="text-theme-2">@lang('general.name')</th>
                                                        <th class="text-theme-2">@lang('general.symbol')</th>
                                                        <th class="text-theme-2">@lang('general.devaluation')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="description" class="tab-pane fade overflow">
                                        <div class="tab-ctn">
                                            <p class="multi-line-text">{{ $user->description }}</p>
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
    <!--End Currency Area-->

    @if($user->is_confirmed)
        @component('components.modal', [
            'title' => 'Bloquer l\'utilisateur ' . $user->format_full_name,
            'id' => 'disable-user', 'color' => 'modal-danger', 'method' => 'PUT',
            'action_route' => route('admin.users.disable', [$user])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @else
        @component('components.modal', [
            'title' => 'Confirmer l\'utilisateur ' . $user->format_full_name,
            'id' => 'enable-user', 'color' => 'modal-success', 'method' => 'PUT',
            'action_route' => route('admin.users.enable', [$user])
            ])
            @lang('general.cfm_action')?
        @endcomponent
    @endif
@endsection



