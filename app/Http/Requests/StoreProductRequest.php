<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'productName' => 'required|string',
    //         'qty' => 'required|integer',
    //         'productPrice' => 'required|float',
    //         'availability' => 'nullable|tinyInteger',
    //     ];
    // }
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


    //  public function messages()
    // {
    //     return [
    //         'productName.required' => 'The product name field is required.',
    //         'productName.max' => 'The product name may not be greater than 255 characters.',
    //         'qty.required' => 'The quantity field is required.',
    //         'qty.integer' => 'The quantity must be an integer.',
    //         'qty.min' => 'The quantity must be at least 0.',
    //         'productPrice.required' => 'The price field is required.',
    //         'productPrice.numeric' => 'The price must be a number.',
    //         'productPrice.min' => 'The price must be at least 0.01.',
    //         'productPrice.max' => 'The price may not be greater than 999999.99.',
    //         'availability.required' => 'The availability field is required.',
    //         'availability.in' => 'The selected availability is invalid.',
    //         'description.max' => 'The description may not be greater than 1000 characters.',
    //         'productImage.image' => 'The file must be an image.',
    //         'productImage.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
    //         'productImage.max' => 'The image may not be greater than 2MB.',
    //         'productImage.dimensions' => 'The image may not be greater than 2000x2000 pixels.',
    //         'category_id.required' => 'The category field is required.',
    //         'category_id.exists' => 'The selected category is invalid.',
    //         'sub_category_id.exists' => 'The selected sub category is invalid.',
    //         'color.required' => 'The color field is required.',
    //         'color.max' => 'The color may not be greater than 50 characters.',
    //         'size.required' => 'Please select at least one size.',
    //         'size.min' => 'Please select at least one size.',
    //         'size.*.exists' => 'One or more selected sizes are invalid.',
    //     ];
    // }
}
