<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogId = $this->route('blog') ? $this->route('blog')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs')->ignore($blogId)
            ],
            'blog_category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keyword' => 'nullable|string|max:255',
            'status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Blog title is required.',
            'slug.required' => 'Blog slug is required.',
            'slug.unique' => 'This slug is already taken.',
            'blog_category_id.required' => 'Please select a category.',
            'description.required' => 'Blog description is required.',
        ];
    }
}