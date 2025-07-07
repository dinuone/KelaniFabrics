<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $this->dd();
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'address' => 'required|string',
            'dob' => 'nullable|date',
            'phoneNumber' => 'nullable|string|min:10|max:12|unique:employees,contact_number,'.$this->id,
            'joinDate' => 'nullable|date|before:tomorrow',
            'resignDate' => 'nullable|date|after:joinDate',
        ];
    }
}
