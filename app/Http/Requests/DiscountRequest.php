<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,amount',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'expire_date' => 'required|date|after:today',
            'status' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Discount name is required',
            'type.required' => 'Discount type is required',
            'type.in' => 'Discount type must be either percentage or amount',
            'value.required' => 'Discount value is required',
            'value.numeric' => 'Discount value must be a number',
            'value.min' => 'Discount value cannot be negative',
            'expire_date.required' => 'Expire date is required',
            'expire_date.after' => 'Expire date must be after today'
        ];
    }
}
