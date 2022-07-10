<?php

namespace Support\Providers;

use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyUser;
use Domain\Invite\Models\Invite;
use Domain\Permission\Observers\PermissionCreatedObserver;
use Domain\Supervisor\Models\Supervisor;
use Domain\User\Models\User;
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

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        User::observe(User::getObservers());
        Invite::observe(Invite::getObservers());
        Company::observe(Company::getObservers());
        Supervisor::observe(Supervisor::getObservers());
        CompanyUser::observe(CompanyUser::getObservers());

        Permission::observe([
            PermissionCreatedObserver::class,
        ]);
    }
}
