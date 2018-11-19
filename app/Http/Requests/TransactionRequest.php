<?php

namespace App\Http\Requests;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'transaction_amount' => $this->required_numeric,
            'date' => $this->required_string_2_30
        ];
    }
}
