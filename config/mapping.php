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

    \Domain\Job\Models\JobOperation::class => [
        'duration_time' => [
            'good' => 800,
            'medium' => 2000,
        ],
    ],

    \Domain\Cms\Models\CmsTable::class => [
        'required' => [
            'columns' => ['id', 'created_at', 'updated_at'],
        ],
        'used' => [
            'names' => ['cms_tables', 'cms_columns', 'migrations'],
        ],
    ],

    \Domain\Cms\Models\CmsColumn::class => [
        'original' => [
            'key' => 'original_key',
        ],
    ],
];
