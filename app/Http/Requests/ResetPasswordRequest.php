<?php

namespace App\Http\Requests;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => $this->required_string_2_255 . '|confirmed'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.confirmed' => trans('password_unconfirmed')
        ];
    }
}
