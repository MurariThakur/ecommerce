<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->route('id');
        }

        return $rules;
    }
}