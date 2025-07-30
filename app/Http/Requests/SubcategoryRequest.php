<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubcategoryRequest extends FormRequest
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
        $subcategoryId = $this->route('subcategory') ? $this->route('subcategory')->id : null;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('subcategories')->ignore($subcategoryId),
            ],
            'category_id' => 'required|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keyword' => 'nullable|string|max:500',
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
            'name.required' => 'Subcategory name is required.',
            'name.max' => 'Subcategory name cannot exceed 255 characters.',
            'slug.required' => 'Subcategory slug is required.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'slug.regex' => 'Slug can only contain lowercase letters, numbers, and hyphens.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'meta_title.max' => 'Meta title cannot exceed 255 characters.',
            'meta_description.max' => 'Meta description cannot exceed 1000 characters.',
            'meta_keyword.max' => 'Meta keywords cannot exceed 500 characters.',
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
            'category_id' => 'category',
            'meta_title' => 'meta title',
            'meta_description' => 'meta description',
            'meta_keyword' => 'meta keywords',
        ];
    }
}
