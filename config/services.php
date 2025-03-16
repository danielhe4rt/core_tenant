<?php

declare(strict_types = 1);

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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
    ],

    'evolution' => [
        'key'         => env('EVOLUTION_API_KEY'),
        'url'         => env('EVOLUTION_URL'),
        'url_webhook' => env('EVOLUTION_URL_WEBHOOK'),
    ],
    'kick' => [
        'base_url'      => env('KICK_BASE_URL', ''),
        'key'           => env('KICK_API_KEY'),
        'client_id'     => env('KICK_CLIENT_ID'),
        'client_secret' => env('KICK_CLIENT_SECRET'),
        'redirect_uri'  => env('KICK_REDIRECT_URI'),
        'scopes'        => [
            'user:read',
            'events:subscribe',
        ],
    ],

];
