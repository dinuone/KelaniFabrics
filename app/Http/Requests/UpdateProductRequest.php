<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
          return [
            'productName' => 'required|string|max:255',
            'productPrice' => 'required|numeric|min:0.01|max:999999.99',
            'description' => 'nullable|string|max:1000',
            'productImage' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,',
            ],
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'color' => 'required|string|max:50',
            'size' => 'required|array|min:1',
            // 'size.*' => 'integer|exists:sizes,id',
        ];
    }
}
