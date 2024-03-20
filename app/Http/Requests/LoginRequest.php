<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('general.email_address_required'),
            'email.email' => __('general.email_address_is_not_in_valid_format'),
            'password.required' => __('general.password_required'),
            'password.min' => __('general.password_must_consiwst_of_minimum_6_characters'),
        ];
    }

}
