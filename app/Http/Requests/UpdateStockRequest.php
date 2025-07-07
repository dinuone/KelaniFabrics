<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
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
   public function rules()
    {
        return [
            'color_id' => ['required', 'integer', 'min:1'], 
            'size_id' => ['required', 'integer', 'min:1'],
            'receive_qty' => ['required', 'integer', ],
            'availability' => ['required', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0'],
            'product_id' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'color_id.required' => 'Color is required.',
            'size_id.required' => 'Size is required.',
            'receive_qty.required' => 'Quantity is required.',
            'availability.required' => 'Availability status is required.',
            'price.required' => 'Price is required.',
            'product_id.required' => 'Product ID is required.',
        ];
    }
}
