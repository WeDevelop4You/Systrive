<?php

namespace App;

use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Domain\Invite\Jobs\CheckInviteHasExpired;
use Domain\System\Jobs\SyncSystemAll;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class ConsoleKernel extends Kernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(CheckInviteHasExpired::class)
            ->name('User invites')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule->job(SyncSystemAll::class)
            ->name('System')
            ->dailyAt('3:00')
            ->withoutOverlapping();

        $schedule->command('model:prune', ['--model' => [Company::class, Cms::class]])
            ->name('Clean database')
            ->dailyAt('3:00')
            ->runInBackground();

        $schedule->command('storage:clear-tmp')
            ->name('Clear tmp folder')
            ->dailyAt('3:00')
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Console/Commands');

        require base_path('routes/console.php');
    }
}
