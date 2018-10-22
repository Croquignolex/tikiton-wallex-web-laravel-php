<?php

namespace App\Traits;

trait RequestTrait
{
    private $string = 'string';
    private $numeric = 'numeric';
    private $required = 'required';
    private $required_string = 'required|string';
    private $required_numeric = 'required|numeric';
    private $required_email = 'required|string|min:2|max:255|email';
    private $required_string_2_255 = 'required|string|min:2|max:255';
    private $required_string_2_510 = 'required|string|min:2|max:510';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}