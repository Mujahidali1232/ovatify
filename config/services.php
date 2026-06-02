<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'suno' => [
        'api_key' => env('SUNO_API_KEY'),
        'api_url' => env('SUNO_API_URL', 'https://api.sunoapi.org'),
    ],
    'stripe' => [
        'public' => env('STRIPE_PUBLIC_KEY'),
        'secret' => env('STRIPE_SECRET_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    'platform' => [
        'fee' => env('PLATFORM_FEE_PERCENTAGE', 10),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URL'),
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT_URL'),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],

    'dolby' => [
        'api_key' => env('DOLBY_API_KEY'),
        'app_secret' => env('DOLBY_APP_SECRET'),
    ],

    'cyanite' => [
        'api_key' => env('CYANITE_API_KEY'),
    ],

    'firebase' => [
        'credentials_path' => storage_path(env('FIREBASE_CREDENTIALS_PATH', 'firebase-auth.json')),
    ],

];
