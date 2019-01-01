@extends('layouts.admin.breadcrumb')

@section('breadcrumb.admin.layout.title', admin_page_title('Utilisateurs'))

@section('breadcrumb.title', 'Utilisateurs')

@section('breadcrumb.message')
    <a href="{{ route('admin.users.index') }}">Utilisateurs</a>
    ({{ $paginationTools->itemsNumber }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-users"></i>
@endsection

@section('breadcrumb.admin.layout.body')
    <!--Start Users Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        @component('components.admin.pagination',
                            ['paginationTools' => $paginationTools])
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="white-container table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="text-theme-2">#</th>
                                        <th class="text-theme-2">@lang('general.name')</th>
                                        <th class="text-theme-2">@lang('general.email')</th>
                                        <th class="text-theme-2">@lang('general.accounts')</th>
                                        <th class="text-theme-2">@lang('general.categories')</th>
                                        <th class="text-theme-2">@lang('general.currencies')</th>
                                        <th class="text-theme-2">Confirmé</th>
                                        <th class="text-theme-2">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paginationTools->displayItems as $user)
                                        <tr>
                                            <td>{{ ($loop->index + 1) + ($paginationTools->itemsPerPage * ($paginationTools->currentPage - 1)) }}</td>
                                            <td>{{ text_format($user->format_full_name, 20) }}</td>
                                            <td>{{ text_format($user->email, 20) }}</td>
                                            <td class="text-right">{{ $user->wallets->count() }}</td>
                                            <td class="text-right">{{ $user->categories->count() }}</td>
                                            <td class="text-right">{{ $user->currencies->count() }}</td>
                                            <td>
                                                @if($user->is_confirmed)
                                                    <small class="text-success">Oui</small>
                                                @else
                                                    <small class="text-danger">Non</small>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.users.show', [$user]) }}" class="text-theme-2" title="@lang('general.details')"><i class="fa fa-eye"></i></a>&nbsp;
                                                @if($user->is_confirmed)
                                                    <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#disable-user-{{ $user->id }}"
                                                       title="@lang('general.disable')"><i class="fa fa-times"></i></a>
                                                @else
                                                    <a href="javascript: void(0);" class="text-success" data-toggle="modal" data-target="#enable-user-{{ $user->id }}"
                                                       title="@lang('general.enable')"><i class="fa fa-check"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center">
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
                                        <th class="text-theme-2">@lang('general.email')</th>
                                        <th class="text-theme-2">@lang('general.accounts')</th>
                                        <th class="text-theme-2">@lang('general.categories')</th>
                                        <th class="text-theme-2">@lang('general.currencies')</th>
                                        <th class="text-theme-2">Confirmé</th>
                                        <th class="text-theme-2">@lang('general.actions')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.admin.pagination',
                            ['paginationTools' => $paginationTools])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Users Area-->

    @foreach($paginationTools->displayItems as $user)
        @if($user->is_confirmed)
            @component('components.modal', [
                'title' => 'Bloquer l\'utilisateur ' . $user->format_full_name,
                'id' => 'disable-user-' . $user->id, 'color' => 'modal-danger', 'method' => 'PUT',
                'action_route' => route('admin.users.disable', [$user])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @else
            @component('components.modal', [
                'title' => 'Confirmer l\'utilisateur ' . $user->format_full_name,
                'id' => 'enable-user-' . $user->id, 'color' => 'modal-success', 'method' => 'PUT',
                'action_route' => route('admin.users.enable', [$user])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection



