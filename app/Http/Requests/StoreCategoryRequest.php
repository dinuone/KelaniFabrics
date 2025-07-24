<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function attributes(): array
    {
        return [
            'catName' => 'category name',
            'catStatus' => 'category status',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //$this->dd();
        return [
            'catName' => 'required|string',
            'catStatus' => 'required|string',
        ];
    }
}
