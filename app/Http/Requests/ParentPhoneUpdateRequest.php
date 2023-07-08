<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentPhoneUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|regex:/9989[0-9]{1}[0-9]{7}/',
            'code' => 'required|string'
        ];
    }
}
