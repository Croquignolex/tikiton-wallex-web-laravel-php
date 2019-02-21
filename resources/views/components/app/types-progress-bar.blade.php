<!--Start Type Progress Bar Area-->
<div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" style="width: {{ $incomesPercent }}%" data-content="@lang('general.incomes')" data-trigger="hover" data-toggle="popover" data-placement="bottom">{{ $incomesPercent }}%</div>
    <div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar" style="width: {{ $expensesPercent }}%" data-content="@lang('general.expenses')" data-trigger="hover" data-toggle="popover" data-placement="bottom">{{ $expensesPercent }}%</div>
</div>
<!--End Type Progress Bar Area-->