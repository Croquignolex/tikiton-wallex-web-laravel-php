<textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows ?? 6 }}"
        {{ $attribute ?? '' }}
        minlength="{{ $min_length ?? 2 }}"
        maxlength="{{ $max_length ?? 510 }}"
        placeholder="{{ $placeholder ?? '' }}"
        data-validate="{{ $validate ?? 'true' }}"
        class="{{ $class ?? '' }} {{ $errors->has($name) ? 'form-invalid' : '' }} min_max"
        @input="validateFormElement">{{ $value }}</textarea>