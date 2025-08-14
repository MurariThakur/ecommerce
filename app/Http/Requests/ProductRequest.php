<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId)
            ],
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'nullable|integer',
            'old_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'shipping_return' => 'nullable|string',
            'status' => 'boolean',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*.size_name' => 'required|string|max:50',
            'sizes.*.size_value' => 'nullable',
            'sizes.*.additional_price' => 'nullable|numeric|min:0',
            'sizes.*.stock_quantity' => 'nullable|integer|min:0',
            // Image file upload validation
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120', // max 5MB each
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Product title is required.',
            'slug.required' => 'Product slug is required.',
            'slug.unique' => 'This slug is already taken.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'subcategory_id.exists' => 'Selected subcategory does not exist.',
            'price.required' => 'Product price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be greater than or equal to 0.',
            'old_price.numeric' => 'Old price must be a valid number.',
            'old_price.min' => 'Old price must be greater than or equal to 0.',
            'sizes.*.size_name.required' => 'Size name is required for each size variation.',
            'sizes.*.size_name.string' => 'Size name must be a string.',
            'sizes.*.size_name.max' => 'Size name cannot be longer than 50 characters.',
            'sizes.*.additional_price.numeric' => 'Additional price must be a valid number.',
            'sizes.*.additional_price.min' => 'Additional price cannot be negative.',
            'sizes.*.stock_quantity.integer' => 'Stock quantity must be a whole number.',
            'sizes.*.stock_quantity.min' => 'Stock quantity cannot be negative.',
            // Image validation messages
            'images.max' => 'You can upload a maximum of 10 images.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Image format must be jpeg, jpg, png, gif, or webp.',
            'images.*.max' => 'Each image must be no larger than 5MB.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->old_price && $this->price && $this->old_price <= $this->price) {
                $validator->errors()->add('old_price', 'Old price must be greater than current price.');
            }
        });
    }
}
