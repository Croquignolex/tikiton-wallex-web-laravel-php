<input
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attribute ?? '' }}
        value="{{ $value ?? '' }}"
        type="{{ $type ?? 'text' }}"
        minlength="{{ $min_length ?? 2 }}"
        maxlength="{{ $max_length ?? 255 }}"
        placeholder="{{ $placeholder ?? '' }}"
        data-validate="{{ $validate ?? 'true' }}"
        class="{{ $class ?? '' }} {{ $errors->has($name) ? 'form-invalid' : '' }} min_max"
        @input="validateFormElement" />