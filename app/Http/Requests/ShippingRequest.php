<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Shipping name is required',
            'name.max' => 'Shipping name cannot exceed 255 characters',
            'price.required' => 'Shipping price is required',
            'price.numeric' => 'Shipping price must be a number',
            'price.min' => 'Shipping price cannot be negative'
        ];
    }
}
