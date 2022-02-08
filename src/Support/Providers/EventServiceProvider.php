<?php

namespace Support\Providers;

use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyUser;
use Domain\Company\Observers\CompanyDeletedObserver;
use Domain\Company\Observers\CompanyUserDetachObserver;
use Domain\Company\Observers\CompanyUserUpdatedObserver;
use Domain\Invite\Models\Invite;
use Domain\Invite\Observers\InviteCreatedObserver;
use Domain\Permission\Observers\PermissionCreatedObserver;
use Domain\User\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PasswordReset::class => [
            ResetPasswordNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        Company::observe([
            CompanyDeletedObserver::class,
        ]);

        CompanyUser::observe([
            CompanyUserUpdatedObserver::class,
            CompanyUserDetachObserver::class,
        ]);

        Permission::observe([
            PermissionCreatedObserver::class,
        ]);

        Invite::observe([
            InviteCreatedObserver::class,
        ]);
    }
}
