<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->user();

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/[^0-9+]/', '', $value);

                    if (!preg_match('/^(\+7|8)/', $digits)) {
                        $fail('Номер должен начинаться с +7 или 8.');
                        return;
                    }

                    $onlyDigits = str_replace('+', '', $digits);

                    if (strlen($onlyDigits) !== 11) {
                        $fail('Номер телефона должен содержать 11 цифр (без учета +).');
                    }
                },
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->phone) {
            $phone = preg_replace('/[^0-9+]/', '', $this->phone);

            if (strpos($phone, '8') === 0) {
                $phone = '+7' . substr($phone, 1);
            }

            $this->merge(['phone' => $phone]);
        }
    }
}
