<?php

namespace App\Traits;

trait RequestTrait
{
    private $required_string = 'required|string|min:2|max:255';
    private $required_text = 'required|string|min:2|max:510';
    private $required_email = 'required|string|min:2|max:255|email';
    private $required_integer = 'required|numeric';
    private $required_str = 'required|string';

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