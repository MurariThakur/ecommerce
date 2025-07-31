<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorRequest extends FormRequest
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
        $colorId = $this->route('color') ? $this->route('color')->id : null;

        return [
            'name' => 'required|string|max:255',
            'color_code' => [
                'required',
                Rule::unique('colors')->ignore($colorId),
            ],
            'status' => 'required|boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Color name is required.',
            'name.max' => 'Color name cannot exceed 255 characters.',
            'color_code.required' => 'Color code is required.',
            'color_code.unique' => 'This color code is already taken. Please choose a different one.',
            'status.required' => 'Status is required.',
            'status.boolean' => 'Status must be a valid boolean value.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'color name',
            'color_code' => 'color code',
        ];
    }
}
