<?php

namespace Support\Providers;

use Domain\Monitor\Listeners\MonitorCreate;
use Domain\Monitor\Listeners\MonitorFailed;
use Domain\Monitor\Listeners\MonitorProcessed;
use Domain\Monitor\Listeners\MonitorProcessing;
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
     * @var array
     */
    protected $listen = [
        JobQueued::class => [
            MonitorCreate::class
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
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {

    }
}
