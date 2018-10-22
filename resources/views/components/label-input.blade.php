<label for="{{ $name }}">
    {{ $label }} {{ $star ?? '' }}
    @if ($errors->has($name))
        <span class="text-danger">
            {{ $errors->first($name) }}
        </span>
    @endif
</label>
{{ $slot }}