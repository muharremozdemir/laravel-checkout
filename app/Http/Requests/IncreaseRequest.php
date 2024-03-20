<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncreaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'product_id gereklidir'
        ];
    }
}
