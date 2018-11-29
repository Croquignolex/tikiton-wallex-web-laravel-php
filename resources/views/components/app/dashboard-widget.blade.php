<div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
    <div class="website-traffic-ctn">
        <h5>
            @if(\Illuminate\Support\Facades\App::getLocale() === 'en')
                <small>{{ text_format($symbol, 5) }}</small>
            @endif
            <a href="{{ $route }}" title="@lang('general.details')">
                {{ $value }}
            </a>
            @if(\Illuminate\Support\Facades\App::getLocale() === 'fr')
                <small>{{ text_format($symbol, 5) }}</small>
            @endif
        </h5>
        <p>{{ $name }}</p>
    </div>
    <div id="{{ $id }}" class="balance-widget"></div>
</div>