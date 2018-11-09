<?php

namespace App\Http\Requests;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
            'name' => $this->required_string_2_255,
            'description' => $this->required_string_2_510,
            'threshold' => $this->required_numeric,
            'balance' => $this->required_numeric,
            'currency' => $this->required_numeric,
            'color' => $this->required_string . '|min:2|max:255'
        ];
    }
}
