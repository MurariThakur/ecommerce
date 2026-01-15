<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get setting value with caching
     */
    public static function get($key, $default = null)
    {
        try {
            return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
                return Setting::get($key, $default);
            });
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Get mail configuration from settings
     */
    public static function getMailConfig()
    {
        return [
            'default' => self::get('mail_mailer', env('MAIL_MAILER', 'log')),
            'host' => self::get('mail_host', env('MAIL_HOST', '127.0.0.1')),
            'port' => self::get('mail_port', env('MAIL_PORT', 2525)),
            'username' => self::get('mail_username', env('MAIL_USERNAME')),
            'password' => self::get('mail_password', env('MAIL_PASSWORD')),
            'from_address' => self::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
            'from_name' => self::get('mail_from_name', env('MAIL_FROM_NAME', 'Example')),
        ];
    }

    /**
     * Get payment configuration from settings
     */
    public static function getPaymentConfig()
    {
        return [
            'paypal_client_id' => self::get('paypal_client_id', env('PAYPAL_CLIENT_ID', '')),
            'paypal_client_secret' => self::get('paypal_client_secret', env('PAYPAL_CLIENT_SECRET', '')),
            'stripe_public_key' => self::get('stripe_public_key', env('STRIPE_KEY', '')),
            'stripe_secret_key' => self::get('stripe_secret_key', env('STRIPE_SECRET', '')),
        ];
    }
}