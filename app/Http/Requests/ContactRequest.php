<?php

namespace App\Http\Requests;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    use RequestTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => $this->required_email,
            'name' => $this->required_string_2_255,
            'phone' => $this->required_string_2_255,
            'subject' => $this->required_string_2_255,
            'message' => $this->required_string_2_510,
        ];
    }
}
