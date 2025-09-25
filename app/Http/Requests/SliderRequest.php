<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'button_name' => 'nullable|string|max:255',
            'button_link' => 'nullable|url'
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|max:2048';
        } else {
            $rules['image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }
}