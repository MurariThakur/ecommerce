<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

use App\Models\Setting;

return [
    'mode'    => 'sandbox',
    'sandbox' => [
        'client_id'         => Setting::get('paypal_client_id', ''),
        'client_secret'     => Setting::get('paypal_client_secret', ''),
        'app_id'            => 'APP-80W284485P519543T',
    ],
    'live' => [
        'client_id'         => Setting::get('paypal_client_id', ''),
        'client_secret'     => Setting::get('paypal_client_secret', ''),
        'app_id'            => Setting::get('paypal_client_id', ''),
    ],

    'payment_action' => 'Sale',
    'currency'       => 'USD',
    'notify_url'     => '',
    'locale'         => 'en_US',
    'validate_ssl'   => true,
];
