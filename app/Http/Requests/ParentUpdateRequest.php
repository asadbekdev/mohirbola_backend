<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string|regex:/9989[0-9]{1}[0-9]{7}/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ];
    }
}
