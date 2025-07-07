<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCustomerRequest extends FormRequest
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
            'custFName' => 'required|string',
            'custLName' => 'required|string',
            'address' => 'required|string',
            'email' => ['nullable','string',Rule::unique('customers')->ignore($this->route('customer')->id)],
            'gender' => 'nullable|string',

            //
        ];
    }
}
