<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'price_sort' => 'sometimes|in:asc,desc',
            'sort' => 'sometimes|in:price_asc,price_desc', // для админки
        ];
    }
}
