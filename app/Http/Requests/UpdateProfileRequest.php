<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth('sanctum')->user()->id,
            'password' => 'nullable|min:6',
            'password_confirmation' => 'required_with:password|same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'İsim gereklidir',
            'email.required' => 'E-posta adresi gereklidir',
            'email.email' => 'E-Posta adresi geçerli formatta değil',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda',
            'password.min' => 'Parola minimum 6 karakterden oluşmalıdır',
            'password_confirmation.required_with' => 'Parola tekrarı gereklidir',
            'password_confirmation.same' => 'Parola ve parola tekrarı eşleşmiyor'
        ];
    }

}
