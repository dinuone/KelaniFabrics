<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'receive_qty' => ['required', 'integer', 'min:1'],
            'availability' => ['required', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0'],
            'product_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
