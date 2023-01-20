<?php

namespace Support\Providers;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsFile;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Observers\CmsColumnDeletingObserver;
use Domain\Cms\Observers\CmsColumnSavingObserver;
use Domain\Cms\Observers\CmsFileForceDeletedObserver;
use Domain\Cms\Observers\CmsForceDeletedObserver;
use Domain\Cms\Observers\CmsModelDeletedObserver;
use Domain\Cms\Observers\CmsModelCreatedObserver;
use Domain\Cms\Observers\CmsTableDeletedObserver;
use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyUser;
use Domain\Company\Observers\CompanyDeletedObserver;
use Domain\Company\Observers\CompanySavingObserver;
use Domain\Company\Observers\CompanyUserDeletingObserver;
use Domain\Company\Observers\CompanyUserUpdatedObserver;
use Domain\Invite\Models\Invite;
use Domain\Invite\Observers\InviteCreatedObserver;
use Domain\Monitor\Listeners\MonitorCreate;
use Domain\Monitor\Listeners\MonitorFailed;
use Domain\Monitor\Listeners\MonitorProcessed;
use Domain\Monitor\Listeners\MonitorProcessing;
use Domain\Permission\Models\Permission;
use Domain\Permission\Observers\PermissionCreatedObserver;
use Domain\Supervisor\Models\Supervisor;
use Domain\Supervisor\Observers\SupervisorDeletingObserver;
use Domain\User\Models\User;
use Domain\User\Observers\UserUpdatingObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobQueued;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array[]
     */
    protected $listen = [
        JobQueued::class => [
            MonitorCreate::class,
        ],
        JobProcessing::class => [
            MonitorProcessing::class,
        ],
        JobProcessed::class => [
            MonitorProcessed::class,
        ],
        JobFailed::class => [
            MonitorFailed::class,
        ],
    ];

    /**
     * @var array[]
     */
    protected $observers = [
        Cms::class => [
            CmsForceDeletedObserver::class
        ],
        CmsColumn::class => [
            CmsColumnSavingObserver::class,
            CmsColumnDeletingObserver::class,
        ],
        CmsFile::class => [
            CmsFileForceDeletedObserver::class
        ],
        CmsModel::class => [
            CmsModelDeletedObserver::class
        ],
        CmsTable::class => [
            CmsTableDeletedObserver::class
        ],
        Company::class => [
            CompanySavingObserver::class,
            CompanyDeletedObserver::class,
        ],
        CompanyUser::class => [
            CompanyUserUpdatedObserver::class,
            CompanyUserDeletingObserver::class,
        ],
        Invite::class => [
            InviteCreatedObserver::class,
        ],
        Permission::class => [
            PermissionCreatedObserver::class,
        ],
        Supervisor::class => [
            SupervisorDeletingObserver::class,
        ],
        User::class => [
            UserUpdatingObserver::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
