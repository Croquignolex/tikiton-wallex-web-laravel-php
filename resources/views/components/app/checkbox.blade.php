<div class="nk-toggle-switch {{ $class ?? '' }}" data-ts-color="{{ $color }}">
    <label for="{{ $name}}" class="ts-label">{{ $label }}</label>
    <input type="checkbox" hidden="hidden" id="{{ $name }}" name="{{ $name }}"
           data-validate="false" {{ $attribute_1 ?? '' }} {{ $attribute_2 ?? '' }} >
    <label for="{{ $name }}" class="ts-helper"></label>
</div>