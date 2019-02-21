<?php

namespace App\Http\Requests;

use App\Traits\RequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'description' => $this->string_510,
            'icon' => $this->required_string_2_255,
            'color' => $this->required_string_2_7
        ];
    }
}
