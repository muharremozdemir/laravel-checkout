<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StatusRule implements Rule
{
    public function passes($attribute, $value)
    {
        return in_array($value, ['Waiting For Approval', 'Approved', 'Denied']);
    }

    public function message()
    {
        return 'Hata: :attribute alanı geçersiz bir değer içeriyor.';
    }
}
