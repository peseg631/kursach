<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price_sort' => 'nullable|in:asc,desc',
        ];
    }
}
