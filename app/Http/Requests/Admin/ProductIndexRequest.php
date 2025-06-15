<?php

namespace App\Http\Requests\Admin;

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
            'sort' => 'nullable|in:price_asc,price_desc',
        ];
    }
}
