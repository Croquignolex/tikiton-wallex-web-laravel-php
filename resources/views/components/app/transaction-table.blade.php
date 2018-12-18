<!--Start Transaction Table Area-->
<table class="table table-bordered table-hover">
    <thead>
        <tr class="text-uppercase">
            <th class="text-theme-1">#</th>
            <th class="text-theme-1">@lang('general.name')</th>
            <th class="text-theme-1">@lang('general.account')</th>
            <th class="text-theme-1">@lang('general.category')</th>
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
                <td><a href="{{ locale_route('transactions.show', [$transaction]) }}" title="@lang('general.details')">{{ text_format($transaction->name, 20) }}</a></td>
                <td>
                    @if($transaction->is_a_transfer)
                        <a href="{{ locale_route('wallets.show', [$transaction->wallet]) }}"
                           style="color:{{ $transaction->wallet->color }}"
                           title="@lang('general.details')">
                            {{ text_format($transaction->wallet->name, 12) }}
                        </a>
                        <i class="fa fa-long-arrow-right"></i>
                        <a href="{{ locale_route('wallets.show', [$transaction->transfer_wallet]) }}"
                           style="color:{{ $transaction->transfer_wallet->color }}"
                           title="@lang('general.details')">
                            {{ text_format($transaction->transfer_wallet->name, 12) }}
                        </a>
                    @else
                        <a href="{{ locale_route('wallets.show', [$transaction->wallet]) }}"
                           style="color:{{ $transaction->wallet->color }}"
                           title="@lang('general.details')">
                            {{ text_format($transaction->wallet->name, 20) }}
                        </a>
                    @endif
                </td>
                <td>
                    <div class="text-center" data-content="{{ $transaction->category->name }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                        <i class="fa fa-{{ $transaction->category->icon }}" style="color:{{ $transaction->category->color }};"></i>
                    </div>
                </td>
                <td class="text-right">
                    <span class="{{ $transaction->category->format_type->color }}">
                        <i class="fa fa-{{ $transaction->category->format_type->icon }}"></i>
                        {{ $transaction->format_amount }}
                    </span>
                </td>
                <td>
                    <div class="text-right" data-content="{{ $transaction->created_time }}" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                        {{ $transaction->created_date }}
                    </div>
                </td>
                @if(!isset($no_action))
                    <td class="text-right">
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
            <th class="text-theme-1">@lang('general.name')</th>
            <th class="text-theme-1">@lang('general.account')</th>
            <th class="text-theme-1">@lang('general.category')</th>
            <th class="text-theme-1">@lang('general.amount')</th>
            <th class="text-theme-1">@lang('general.date')</th>
            @if(!isset($no_action))
                <th class="text-theme-1">@lang('general.actions')</th>
            @endif
        </tr>
    </thead>
</table>
<!--End Transaction Table Area-->