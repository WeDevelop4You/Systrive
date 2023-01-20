<?php

namespace App\Console\Commands\Vesta\Sync;

use Domain\System\Jobs\SyncSystemUsers;
use Illuminate\Console\Command;

class VestaSyncSystemUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vesta:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync system users from vesta';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        SyncSystemUsers::dispatch();

        return 1;
    }
}
