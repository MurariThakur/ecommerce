<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Site Settings
            ['key' => 'site_name', 'value' => 'ShopHub - Your Ultimate Shopping Destination', 'status' => true],
            ['key' => 'site_description', 'value' => 'Discover amazing products at unbeatable prices. From electronics to fashion, we have everything you need.', 'status' => true],
            ['key' => 'site_keywords', 'value' => 'ecommerce, shopping, electronics, fashion, home, garden, books', 'status' => true],
            ['key' => 'contact_email', 'value' => 'info@shophub.com', 'status' => true],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'status' => true],
            ['key' => 'contact_address', 'value' => '123 Commerce Street, Business District, NY 10001', 'status' => true],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/shophub', 'status' => true],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/shophub', 'status' => true],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/shophub', 'status' => true],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/shophub', 'status' => true],
            
            // Mail Settings (defaults)
            ['key' => 'mail_mailer', 'value' => 'smtp', 'status' => true],
            ['key' => 'mail_host', 'value' => 'smtp.mailtrap.io', 'status' => true],
            ['key' => 'mail_port', 'value' => '2525', 'status' => true],
            ['key' => 'mail_username', 'value' => '', 'status' => true],
            ['key' => 'mail_password', 'value' => '', 'status' => true],
            ['key' => 'mail_from_address', 'value' => 'noreply@shophub.com', 'status' => true],
            ['key' => 'mail_from_name', 'value' => 'ShopHub', 'status' => true],
            
            // Payment Settings (defaults)
            ['key' => 'paypal_client_id', 'value' => '', 'status' => true],
            ['key' => 'paypal_client_secret', 'value' => '', 'status' => true],
            ['key' => 'stripe_public_key', 'value' => '', 'status' => true],
            ['key' => 'stripe_secret_key', 'value' => '', 'status' => true],
            
            // Business Settings
            ['key' => 'currency', 'value' => 'USD', 'status' => true],
            ['key' => 'currency_symbol', 'value' => '$', 'status' => true],
            ['key' => 'timezone', 'value' => 'America/New_York', 'status' => true],
            ['key' => 'free_shipping_threshold', 'value' => '50', 'status' => true],
            
            // SEO Settings
            ['key' => 'google_analytics_id', 'value' => '', 'status' => true],
            ['key' => 'google_tag_manager_id', 'value' => '', 'status' => true],
            ['key' => 'facebook_pixel_id', 'value' => '', 'status' => true],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}