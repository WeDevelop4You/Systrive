<?php

namespace App\Console\Commands;

use Domain\Invite\Jobs\CheckInviteHasExpired;
use Illuminate\Console\Command;

class InvitesExpiredCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invites:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set all expired invites to expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        CheckInviteHasExpired::dispatchSync();

        return 1;
    }
}
