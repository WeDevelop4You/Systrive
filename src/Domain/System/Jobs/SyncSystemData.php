<?php

namespace Domain\System\Jobs;

use Domain\System\Models\System;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSystemData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        $this->onQueue('system');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        System::with('domains', 'dns', 'databases', 'mailDomains')->get()
            ->each(function (System $system) {
                SyncSystemDNS::dispatch($system);
                SyncSystemDomains::dispatch($system);
                SyncSystemDatabases::dispatch($system);
                SyncSystemMailDomains::dispatch($system);
            });
    }
}
