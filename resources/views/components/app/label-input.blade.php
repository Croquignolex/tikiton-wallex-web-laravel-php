{{ $slot }}
<label for="{{ $name }}">
    @if ($errors->has($name))
        <span class="text-danger">
            {{ $errors->first($name) }}
        </span>
    @endif
    <small class="text-theme-1">@lang('general.' . $name)</small>
</label>