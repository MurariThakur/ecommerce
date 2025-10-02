<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => 'sandbox',
    'sandbox' => [
        'client_id'         => \App\Helpers\SettingsHelper::get('paypal_client_id', env('PAYPAL_CLIENT_ID', '')),
        'client_secret'     => \App\Helpers\SettingsHelper::get('paypal_client_secret', env('PAYPAL_CLIENT_SECRET', '')),
        'app_id'            => 'APP-80W284485P519543T',
    ],
    'live' => [
        'client_id'         => \App\Helpers\SettingsHelper::get('paypal_live_client_id', env('PAYPAL_LIVE_CLIENT_ID', '')),
        'client_secret'     => \App\Helpers\SettingsHelper::get('paypal_live_client_secret', env('PAYPAL_LIVE_CLIENT_SECRET', '')),
        'app_id'            => \App\Helpers\SettingsHelper::get('paypal_live_client_id', env('PAYPAL_LIVE_CLIENT_ID', '')),
    ],

    'payment_action' => 'Sale',
    'currency'       => 'USD',
    'notify_url'     => '',
    'locale'         => 'en_US',
    'validate_ssl'   => true,
];
