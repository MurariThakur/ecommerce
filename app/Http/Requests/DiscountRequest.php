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
            'amount_percentage' => 'required|numeric|min:0',
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
            'amount_percentage.required' => 'Amount/Percentage value is required',
            'amount_percentage.numeric' => 'Amount/Percentage must be a number',
            'amount_percentage.min' => 'Amount/Percentage cannot be negative',
            'expire_date.required' => 'Expiry date is required',
            'expire_date.date' => 'Expiry date must be a valid date',
            'expire_date.after' => 'Expiry date must be after today'
        ];
    }
}
