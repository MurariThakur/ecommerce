<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'free_shipping_threshold' => Setting::firstOrCreate(['key' => 'free_shipping_threshold'], ['value' => '100', 'status' => false]),
            'website_name' => Setting::firstOrCreate(['key' => 'website_name'], ['value' => 'Ecommerce Store']),
            'website_logo' => Setting::firstOrCreate(['key' => 'website_logo'], ['value' => '']),
            'favicon' => Setting::firstOrCreate(['key' => 'favicon'], ['value' => '']),
            'footer_description' => Setting::firstOrCreate(['key' => 'footer_description'], ['value' => '']),
            'footer_payment_icon' => Setting::firstOrCreate(['key' => 'footer_payment_icon'], ['value' => '']),
            'office_address' => Setting::firstOrCreate(['key' => 'office_address'], ['value' => '']),
            'mobile' => Setting::firstOrCreate(['key' => 'mobile'], ['value' => '']),
            'alternative_mobile' => Setting::firstOrCreate(['key' => 'alternative_mobile'], ['value' => '']),
            'email' => Setting::firstOrCreate(['key' => 'email'], ['value' => '']),
            'alternative_email' => Setting::firstOrCreate(['key' => 'alternative_email'], ['value' => '']),
            'working_hours' => Setting::firstOrCreate(['key' => 'working_hours'], ['value' => '']),
            'facebook_link' => Setting::firstOrCreate(['key' => 'facebook_link'], ['value' => '']),
            'instagram_link' => Setting::firstOrCreate(['key' => 'instagram_link'], ['value' => '']),
            'twitter_link' => Setting::firstOrCreate(['key' => 'twitter_link'], ['value' => '']),
            'youtube_link' => Setting::firstOrCreate(['key' => 'youtube_link'], ['value' => '']),
            'pinterest_link' => Setting::firstOrCreate(['key' => 'pinterest_link'], ['value' => '']),
            'turnstile_site_key' => Setting::firstOrCreate(['key' => 'turnstile_site_key'], ['value' => '']),
            'stripe_public_key' => Setting::firstOrCreate(['key' => 'stripe_public_key'], ['value' => '']),
            'stripe_secret_key' => Setting::firstOrCreate(['key' => 'stripe_secret_key'], ['value' => '']),
            'stripe_status' => Setting::firstOrCreate(['key' => 'stripe_status'], ['value' => '', 'status' => false]),
            'paypal_client_id' => Setting::firstOrCreate(['key' => 'paypal_client_id'], ['value' => '']),
            'paypal_client_secret' => Setting::firstOrCreate(['key' => 'paypal_client_secret'], ['value' => '']),
            'paypal_status' => Setting::firstOrCreate(['key' => 'paypal_status'], ['value' => '', 'status' => false]),
            'razorpay_key_id' => Setting::firstOrCreate(['key' => 'razorpay_key_id'], ['value' => '']),
            'razorpay_key_secret' => Setting::firstOrCreate(['key' => 'razorpay_key_secret'], ['value' => '']),
            'razorpay_status' => Setting::firstOrCreate(['key' => 'razorpay_status'], ['value' => '', 'status' => false]),
            'mail_mailer' => Setting::firstOrCreate(['key' => 'mail_mailer'], ['value' => 'log']),
            'mail_host' => Setting::firstOrCreate(['key' => 'mail_host'], ['value' => '']),
            'mail_port' => Setting::firstOrCreate(['key' => 'mail_port'], ['value' => '587']),
            'mail_username' => Setting::firstOrCreate(['key' => 'mail_username'], ['value' => '']),
            'mail_password' => Setting::firstOrCreate(['key' => 'mail_password'], ['value' => '']),
            'mail_from_address' => Setting::firstOrCreate(['key' => 'mail_from_address'], ['value' => '']),
            'mail_from_name' => Setting::firstOrCreate(['key' => 'mail_from_name'], ['value' => '']),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Debug: Check if files are being received
        if ($request->hasFile('website_logo')) {
            \Log::info('Website logo file received: ' . $request->file('website_logo')->getClientOriginalName());
        }

        $request->validate([
            'free_shipping_threshold' => 'required|numeric|min:0',
            'website_name' => 'required|string|max:255',
            'website_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'footer_payment_icon' => 'nullable|image|max:2048',
            'email' => 'nullable|email',
            'alternative_email' => 'nullable|email',
        ]);

        // Update all settings
        $settingsData = [
            'free_shipping_threshold' => $request->free_shipping_threshold,
            'website_name' => $request->website_name,
            'footer_description' => $request->footer_description,
            'office_address' => $request->office_address,
            'mobile' => $request->mobile,
            'alternative_mobile' => $request->alternative_mobile,
            'email' => $request->email,
            'alternative_email' => $request->alternative_email,
            'working_hours' => $request->working_hours,
            'facebook_link' => $request->facebook_link,
            'instagram_link' => $request->instagram_link,
            'twitter_link' => $request->twitter_link,
            'youtube_link' => $request->youtube_link,
            'pinterest_link' => $request->pinterest_link,
            'turnstile_site_key' => $request->turnstile_site_key,
            'stripe_public_key' => $request->stripe_public_key,
            'stripe_secret_key' => $request->stripe_secret_key,
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_client_secret' => $request->paypal_client_secret,
            'razorpay_key_id' => $request->razorpay_key_id,
            'razorpay_key_secret' => $request->razorpay_key_secret,
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];

        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle file uploads
        $uploads = ['website_logo', 'favicon', 'footer_payment_icon'];
        foreach ($uploads as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $path = $file->store('settings', 'public');
                Setting::updateOrCreate(['key' => $field], ['value' => $path]);
            }
        }

        // Update payment gateway statuses
        Setting::where('key', 'free_shipping_threshold')->update(['status' => $request->has('free_shipping_status')]);
        Setting::where('key', 'stripe_status')->update(['status' => $request->has('stripe_status')]);
        Setting::where('key', 'paypal_status')->update(['status' => $request->has('paypal_status')]);
        Setting::where('key', 'razorpay_status')->update(['status' => $request->has('razorpay_status')]);

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
