<?php

    return [
        'admin' => [
            'routes' => [
                'domain' => 'systrive.wedevelop4you.nl',
                'path' => base_path(app_path('Admin')),
                'files' => [
                    [
                        'prefix' => 'api',
                        'filename' => 'api.php',
                        'middleware' => 'api',
                    ],
                    [
                        'filename' => 'web.php',
                        'middleware' => 'web',
                    ],
                ],
            ],

            'api' => [
                'filename' => 'api.json',
                'store_path' => resource_path('admin/js/config'),
            ],
        ],

        'site' => [
            'routes' => [
                'path' => base_path(app_path('Site')),
                'files' => [
                    [
                        'prefix' => 'api',
                        'filename' => 'api.php',
                        'middleware' => 'api',
                    ],
                    [
                        'filename' => 'web.php',
                        'middleware' => 'web',
                    ],
                ],
            ],
        ],
    ];
