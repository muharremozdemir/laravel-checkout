<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'E-posta adresi gereklidir',
            'email.email' => 'E-posta adresi geçerli formatta değil',
        ];
    }
}
