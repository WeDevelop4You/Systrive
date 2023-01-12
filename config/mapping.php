<?php

return [
    \Domain\Role\Models\Role::class => [
        'role' => [
            'super_admin' => 'super_admin',
            'main' => 'Admin',
        ],
    ],

    \Domain\Monitor\Models\Monitor::class => [
        'duration_time' => [
            'good' => 1000,
            'medium' => 3000,
        ],
    ],

    \Domain\System\Models\SystemUsageStatistic::class => [
        'morph' => [
            'model' => 'model',
        ],
    ],

    \Domain\Cms\Models\CmsTable::class => [
        'required' => [
            'columns' => ['id', 'created_at', 'updated_at'],
        ],
        'used' => [
            'names' => ['cms_tables', 'cms_columns', 'cms_files', 'migrations'],
        ],
    ],

    \Domain\Cms\Models\CmsColumn::class => [
        'col' => [
            'original_key' => 'original_key',
        ],
    ],
];
