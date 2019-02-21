<!--Start Transaction Table Area-->
<table class="table table-bordered table-hover">
    <thead>
        <tr class="text-uppercase">
            <th class="text-theme-1">#</th>
            <th class="text-theme-1">@lang('general.category')</th>
            <th class="text-theme-1">@lang('general.account')</th>
            <th class="text-theme-1">@lang('general.amount')</th>
            <th class="text-theme-1">@lang('general.date')</th>
            @if(!isset($no_action))
                <th class="text-theme-1">@lang('general.actions')</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $transaction)
            <tr class="{{ !$transaction->is_stated ? 'current' : '' }}">
                <td>{{ $loop->index + 1 }}</td>
                <td>
                    @if($transaction->is_a_transfer)
                        <span style="color:{{ $transaction->category->color }};">
                            <i class="fa fa-{{ $transaction->category->icon }}"></i>
                            {{ $transaction->category->name }}
                        </span>
                    @else
                        <a data-content="{{ $transaction->category->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom"
                           href="{{ locale_route('categories.show', [$transaction->category]) }}"
                           style="color:{{ $transaction->category->color }};">
                            <i class="fa fa-{{ $transaction->category->icon }}"></i>
                            {{ $transaction->category->table_name }}
                        </a>
                    @endif
                </td>
                <td>
                    @if($transaction->is_a_transfer)
                        <a data-content="{{ $transaction->wallet->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom"
                           href="{{ locale_route('wallets.show', [$transaction->wallet]) }}"
                           style="color:{{ $transaction->wallet->color }}">
                            {{ $transaction->wallet->table_name }}
                        </a>
                        <i class="fa fa-long-arrow-right"></i>
                        <a data-content="{{ $transaction->transfer_wallet->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom"
                           href="{{ locale_route('wallets.show', [$transaction->transfer_wallet]) }}"
                           style="color:{{ $transaction->transfer_wallet->color }}">
                            {{ $transaction->transfer_wallet->table_name }}
                        </a>
                    @else
                        <a data-content="{{ $transaction->wallet->popover_name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom"
                           href="{{ locale_route('wallets.show', [$transaction->wallet]) }}"
                           style="color:{{ $transaction->wallet->color }}">
                            {{ $transaction->wallet->table_name }}
                        </a>
                    @endif
                </td>
                <td class="text-right">
                    <span class="{{ $transaction->category->format_type->color }}">
                        <i class="fa fa-{{ $transaction->category->format_type->icon }}"></i>
                        {{ $transaction->format_amount }}
                    </span>
                </td>
                <td class="text-right">
                    <span class="text-right" data-content="{{ $transaction->long_created_date }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                        {{ $transaction->created_date }} {{ $transaction->created_time }}
                    </span>
                </td>
                @if(!isset($no_action))
                    <td class="text-right">
                        <a href="{{ locale_route('transactions.show', [$transaction]) }}" class="text-theme-1" title="@lang('general.details')"><i class="fa fa-eye"></i></a>&nbsp;
                        <a href="{{ locale_route('transactions.edit', [$transaction]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                        @if($transaction->can_be_deleted)
                            <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-transaction-{{ $transaction->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                        @endif
                    </td>
                @endif
            </tr>
        @empty
            <td colspan="{{ $no_action ?? '7' }}" class="text-center">
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
            <th class="text-theme-1">@lang('general.category')</th>
            <th class="text-theme-1">@lang('general.account')</th>
            <th class="text-theme-1">@lang('general.amount')</th>
            <th class="text-theme-1">@lang('general.date')</th>
            @if(!isset($no_action))
                <th class="text-theme-1">@lang('general.actions')</th>
            @endif
        </tr>
    </thead>
</table>
<!--End Transaction Table Area-->