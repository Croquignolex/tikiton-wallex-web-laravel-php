<div class="white-container">
    <a href="#" class="chart-dismiss" data-dismiss="alert" aria-label="Close"
       @click="{{ $event_function_name }}">
        <small aria-hidden="true"><i class="fa fa-repeat"></i></small>
    </a>
    <span class="text-uppercase">
        <a href="{{ $report_route }}" title="@lang('general.details')">{{ $title }}</a>
        ({{ $title_date }})
    </span>
    <div id="{{ $loader_id }}" class="text-center chart-loader" style="display: block">
        <img src="{{ img_asset('loader', 'gif') }}" alt="...">
    </div>
    <canvas id="{{ $chart_id }}" class="chart-canvas" style="display: none"></canvas>
</div>