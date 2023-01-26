<?php

return [
    'main' => [
        'path' => application_path('Main'),
        'routes' => [
            'files' => [
                [
                    'filename' => 'web.php',
                    'middleware' => 'web',
                ],
            ],
            'plurals' => [
                'index' => '',
            ],
        ],
    ],
    'account' => [
        'path' => application_path('Account'),
        'routes' => [
            'domain' => env('DOMAIN_ACCOUNT'),
            'files' => [
                [
                    'prefix' => 'api',
                    'filename' => 'api.php',
                    'middleware' => 'api',
                ], [
                    'filename' => 'web.php',
                    'middleware' => 'web',
                ],
            ],
            'plurals' => [
                'user' => 'user',
                'authentication' => '',
            ],
        ],
    ],

    'admin' => [
        'path' => application_path('Admin'),
        'routes' => [
            'domain' => env('DOMAIN_ADMIN'),
            'files' => [
                [
                    'prefix' => 'api',
                    'filename' => 'api.php',
                    'middleware' => ['api', 'auth:sanctum', 'auth.role', 'role:super_admin'],
                ], [
                    'filename' => 'web.php',
                    'middleware' => ['web', 'auth:sanctum', 'auth.role', 'role:super_admin'],
                ],
            ],
            'plurals' => [
                'dashboard' => '',
                'cms' => 'company',
                'supervisor' => 'supervisor',
            ],
        ],
    ],

    'company' => [
        'path' => application_path('Company'),
        'routes' => [
            'domain' => env('DOMAIN_COMPANY'),
            'files' => [
                [
                    'prefix' => 'api',
                    'filename' => 'api.switcher.php',
                    'middleware' => ['api', 'auth:sanctum', 'auth.role'],
                ], [
                    'prefix' => 'api/{company}',
                    'filename' => 'api.php',
                    'middleware' => ['api', 'auth:sanctum', 'auth.role'],
                ], [
                    'prefix' => 'api/{company:slug}',
                    'filename' => 'api.slug.php',
                    'middleware' => ['api', 'auth:sanctum', 'auth.role'],
                ], [
                    'filename' => 'web.php',
                    'middleware' => ['web', 'auth:sanctum', 'auth.role'],
                ], [
                    'filename' => 'web.invite.php',
                    'middleware' => ['web'],
                ],
            ],
            'plurals' => [
                'git' => 'git',
                'cms' => 'cms',
                'dashboard' => '',
            ],
        ],
    ],

    'misc' => [
        'path' => application_path('Misc'),
        'routes' => [
            'files' => [
                [
                    'prefix' => 'api',
                    'filename' => 'api.php',
                    'middleware' => 'api',
                ], [
                    'filename' => 'web.php',
                    'middleware' => 'web',
                ],
            ],
            'plurals' => [
                'broadcast' => '',
            ],
        ],
    ],
];
