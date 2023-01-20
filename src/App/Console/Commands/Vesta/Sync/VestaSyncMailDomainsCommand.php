<?php

namespace App\Console\Commands\Vesta\Sync;

use Domain\System\Jobs\SyncSystemMailDomains;
use Domain\System\Models\System;
use Illuminate\Console\Command;

class VestaSyncMailDomainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vesta:mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync mail domains from vesta';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        System::with('domains')->get()
            ->each(function (System $system) {
                SyncSystemMailDomains::dispatch($system);
            });

        return 1;
    }
}
