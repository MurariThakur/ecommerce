<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'free_shipping_threshold' => 'required|numeric|min:0',
            'website_name' => 'required|string|max:255',
            'website_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'footer_payment_icon' => 'nullable|image|max:2048',
            'footer_description' => 'nullable|string',
            'office_address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'alternative_mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'alternative_email' => 'nullable|email',
            'working_hours' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'pinterest_link' => 'nullable|url',
            'turnstile_site_key' => 'nullable|string',
            'stripe_public_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'paypal_client_secret' => 'nullable|string',
            'razorpay_key_id' => 'nullable|string',
            'razorpay_key_secret' => 'nullable|string',
            'mail_mailer' => 'nullable|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
        ];
    }
}