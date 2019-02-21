<?php

namespace App\Http\Requests;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => $this->required_string_2_255,
            'last_name' => $this->required_string_2_255,
            'address' => $this->string_255,
            'post_code' => $this->string_255,
            'phone' => $this->string_255,
            'city' => $this->string_255,
            'country' => $this->string_255,
            'profession' => $this->string_255,
            'description' => $this->string_510
        ];
    }
}
