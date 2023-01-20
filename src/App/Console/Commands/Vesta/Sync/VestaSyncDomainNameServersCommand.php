<?php

namespace App\Console\Commands\Vesta\Sync;

use Domain\System\Jobs\SyncSystemDNS;
use Domain\System\Models\System;
use Illuminate\Console\Command;

class VestaSyncDomainNameServersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vesta:dns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync domain name servers from vesta';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        System::with('dns')->get()
            ->each(function (System $system) {
                SyncSystemDNS::dispatch($system);
            });

        return 1;
    }
}
