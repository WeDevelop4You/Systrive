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
            'ignore_plurals' => [
                'git' => 'git',
                'cms' => 'companies',
                'supervisor' => 'supervisor',
            ],
        ],

        'api' => [
            'filename' => 'api.json',
            'store_path' => resource_path('admin/js/config'),
        ],
    ],
];
