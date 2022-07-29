<?php

use Domain\Git\Enums\GitServiceTypes;

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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => sprintf('/git/%s/callback', GitServiceTypes::GITHUB->value),
    ],

    'gitlab' => [
        'client_id' => env('GITLAB_CLIENT_ID'),
        'client_secret' => env('GITLAB_CLIENT_SECRET'),
        'redirect' => sprintf('/git/%s/callback', GitServiceTypes::GITLAB->value),
    ],

    'vesta' => [
        'hostname' => env('VESTA_HOSTNAME'),
        'username' => env('VESTA_USERNAME'),
        'password' => env('VESTA_PASSWORD'),
    ],

    'supervisor' => [
        'url' => env('SUPERVISOR_URL', 'supervisor.siberhost.nl'),
        'port' => env('SUPERVISOR_PORT', 80),
        'username' => env('SUPERVISOR_USERNAME'),
        'password' => env('SUPERVISOR_PASSWORD'),
    ],
];
