<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'link' => 'nullable|url'
        ];

        if ($this->isMethod('post')) {
            $rules['logo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }
}