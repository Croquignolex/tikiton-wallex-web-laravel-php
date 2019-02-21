@inject('transactionService', 'App\Services\TransactionService')
@extends('layouts.app.breadcrumb')

@section('breadcrumb.app.layout.title', page_title(trans('general.transactions')))

@section('breadcrumb.title', trans('general.transactions'))

@section('breadcrumb.message')
    <a href="{{ locale_route('transactions.index') }}">@lang('general.transactions')</a>
    ({{ $transactions->count() }})
@endsection

@section('breadcrumb.icon')
    <i class="fa fa-random"></i>
@endsection

@section('breadcrumb.app.layout.body')
    <!--Start Currencies Area-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-md-push-6 col-sm-8 col-sm-push-4 col-xs-12">
                        @component('components.date-range', [
                            'begin_date' => $transactionService->getNormalFormatDate($begin_date),
                            'end_date' => $transactionService->getNormalFormatDate($end_date),
                            'route' => locale_route('transactions.filter')
                         ])
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.tips', ['title' => trans('general.transactions')])
                            @lang('tips.transactions')
                        @endcomponent
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @component('components.app.types-progress-bar', [
                            'incomesPercent' => $incomesPercent,
                            'expensesPercent' => $expensesPercent
                        ])
                        @endcomponent
                        <div class="white-container table-responsive">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                [{{ $transactionService->getMediumFormatDate($begin_date) }} -
                                {{ $transactionService->getMediumFormatDate($end_date) }}]
                            </div>
                            @component('components.app.transaction-table',
                                ['transactions' => $transactions])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Currencies Area-->

    @foreach($transactions as $transaction)
        @if($transaction->can_be_deleted)
            @component('components.modal', [
                'title' => trans('general.delete_transaction', ['name' => $transaction->name]),
                'id' => 'delete-transaction-' . $transaction->id, 'color' => 'modal-danger',
                'action_route' => locale_route('transactions.destroy', [$transaction])
                ])
                @lang('general.cfm_action')?
            @endcomponent
        @endif
    @endforeach
@endsection

@push('breadcrumb.app.layout.style.page')
    <link rel="stylesheet" href="{{ css_app_asset('bootstrap-datetimepicker') }}" type="text/css">
@endpush

@push('breadcrumb.app.layout.script.page')
    <script src="{{ js_asset('bootstrap-maxlength') }}" type="text/javascript"></script>
    <script src="{{ js_asset('form-validator') }}" type="text/javascript"></script>
    <script src="{{ js_asset('min-max-3') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('moment-with-locales') }}" type="text/javascript"></script>
    <script src="{{ js_app_asset('bootstrap-datetimepicker') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            let locale = '{{ \Illuminate\Support\Facades\App::getLocale() }}';
            $('#begin_date').datetimepicker({ locale: locale });
            $('#end_date').datetimepicker({ locale: locale, useCurrent: false });
            $("#begin_date").on("dp.change", function (e) { $('#end_date').data("DateTimePicker").minDate(e.date); });
            $("#end_date").on("dp.change", function (e) { $('#begin_date').data("DateTimePicker").maxDate(e.date); });
        });
    </script>
@endpush


