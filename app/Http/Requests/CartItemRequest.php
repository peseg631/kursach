<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1|max:100',
            'selected_items' => 'sometimes|array',
            'selected_items.*' => 'integer|exists:cart_items,id,user_id,'.auth()->id()
        ];
    }

    public function messages(): array
    {
        return [
            'selected_items.*.exists' => 'Selected item does not exist in your cart'
        ];
    }
}
