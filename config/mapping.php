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
        'col' => [
            'columns' => 'columns',
            'columns_all' => 'columns.*',
        ],
        'used' => [
            'names' => ['cms_tables', 'cms_columns', 'cms_files', 'migrations'],
        ],
    ],

    \Domain\Cms\Models\CmsColumn::class => [
        'col' => [
            'original_key' => 'original_key',
            'selectable_all' => 'selectable.*',
            'creatable_all' => 'creatable.*',
            'updatable_all' => 'updatable.*',
        ],
        'required' => [
            'columns' => ['id', 'created_at', 'updated_at'],
        ],
        'reserve' => [
            'columns' => ['_and', '_or'],
        ],
    ],
];
