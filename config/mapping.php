<?php

return [
    \Domain\Role\Models\Role::class => [
        'role' => [
            'super_admin' => 'super_admin',
            'main' => 'Admin',
        ],
    ],

    \Domain\System\Models\SystemUsageStatistic::class => [
        'morph' => [
            'model' => 'model',
        ],
    ],
];
