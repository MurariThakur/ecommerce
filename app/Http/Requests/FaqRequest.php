<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $faqId = $this->route('faq') ? $this->route('faq')->id : null;

        return [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|in:orders,shipping,returns,account',
            'status' => 'boolean',
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($faqId) {
                    if ($value !== null) {
                        $query = \App\Models\Faq::where('category', $this->category)
                            ->where('sort_order', $value);

                        if ($faqId) {
                            $query->where('id', '!=', $faqId);
                        }

                        if ($query->exists()) {
                            $fail('The sort order must be unique for same category.');
                        }
                    }
                }
            ]
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'The question field is required.',
            'answer.required' => 'The answer field is required.',
            'category.required' => 'Please select a category.',
            'category.in' => 'Please select a valid category.',
        ];
    }
}