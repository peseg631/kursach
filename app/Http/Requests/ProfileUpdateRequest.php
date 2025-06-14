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
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/[^0-9]/', '', $value);

                    // Проверяем начало номера (8 или +7)
                    if (!preg_match('/^(\+7|8)/', $value)) {
                        $fail('Номер должен начинаться с +7 или 8.');
                    }

                    // Проверяем общую длину (11 цифр для +7 или 8)
                    if (strlen($digits) !== 11) {
                        $fail('Номер телефона должен содержать 11 цифр.');
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

            // Конвертируем 8 в начале в +7
            if (str_starts_with($phone, '8')) {
                $phone = '+7' . substr($phone, 1);
            }

            $this->merge(['phone' => $phone]);
        }
    }
}
