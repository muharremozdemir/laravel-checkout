<?php

namespace App\Http\Requests;

use App\Rules\StatusRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeOrderStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => 'required',
            "status" => ['required', 'string', new StatusRule]
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'order_id gereklidir',
            'status.required' => 'status gereklidir',
        ];
    }
}
