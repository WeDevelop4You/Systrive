<?php

    return [
        \Domain\Company\Models\Company::class => [
          'status' => [
              'invited' => 'invited',
              'expired' => 'expired',
              'completed' => 'completed',
          ],
        ],

        \Domain\Company\Models\CompanyUser::class => [
            'status' => [
                'expired' => 'expired',
                'accepted' => 'accepted',
                'requested' => 'requested',
            ],
        ],

        \Domain\Invite\Models\Invite::class => [
            'type' => [
                'user' => 'company_user',
                'company' => 'new_company',
            ],
        ],

        \Domain\Role\Models\Role::class => [
            'role' => [
                'main' => 'admin',
            ],
        ],

        \Domain\System\Models\SystemUsageStatistic::class => [
            'morph' => [
                'model' => 'model',
            ],
            'type' => [
                'disk' => 'disk',
                'bandwidth' => 'bandwidth',
            ],

        ],
    ];
