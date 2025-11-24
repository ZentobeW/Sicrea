<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the mailer that is used to send any email messages
    | sent by your application. Use "smtp" for SendGrid or switch to "log"
    | while developing without an SMTP connection.
    |
    */
    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | You may define all of your mailers here as well as their respective
    | settings. A fallback "log" mailer is kept for local debugging.
    |
    */
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'url' => env('MAIL_URL'),
            'scheme' => env('MAIL_SCHEME'),
            'host' => env('MAIL_HOST', 'smtp.sendgrid.net'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Laravel')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin & Test Addresses
    |--------------------------------------------------------------------------
    |
    | Centralize addresses that act as recipients for admin notifications
    | and simple SMTP test emails so controllers/views can pull them from
    | configuration instead of hardcoding.
    |
    */
    'admin_address' => env('MAIL_ADMIN_ADDRESS', env('MAIL_FROM_ADDRESS')),
    'admin_name' => env('MAIL_ADMIN_NAME', env('MAIL_FROM_NAME')),
    'test_recipient' => env('MAIL_TEST_RECIPIENT'),

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing the design of the emails to
    | be customized. Or, you may simply stick with the Laravel defaults!
    |
    */
    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];
