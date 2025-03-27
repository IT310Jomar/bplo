<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Notification Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the default notification channel that is used when
    | sending notifications via the `notify` method on notifiable entities.
    |
    */

    'default' => 'mail', // Change this to your preferred default channel

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the notification "channels" for your application
    | as well as their drivers. You may even define multiple channels for the
    | same driver if needed. Supported drivers are 'mail', 'database', 'broadcast',
    | 'nexmo', 'slack', 'twilio', and others.
    |
    */

    'channels' => [
        // ...

        'twilio' => [
            'driver' => 'twilio',
            'from' => env('TWILIO_PHONE_NUMBER'),
        ],

        // ...
    ],

];
