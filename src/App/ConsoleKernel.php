<?php

    namespace App;

    use Domain\Invite\Jobs\CheckInviteHasExpired;
    use Domain\System\Jobs\SyncSystem;
    use Domain\System\Jobs\SyncSystemDatabases;
    use Domain\System\Jobs\SyncSystemDNS;
    use Domain\System\Jobs\SyncSystemDomains;
    use Domain\System\Jobs\SyncSystemMailDomains;
    use Domain\System\Jobs\SyncSystemTemplates;
    use Domain\System\Models\System;
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
            $schedule->job(new CheckInviteHasExpired())
                 ->name('User invites')
                 ->everyFiveMinutes()
                 ->withoutOverlapping();

            $schedule->job(new SyncSystem())
                ->after(function () {
                    System::with('domains', 'dns', 'databases', 'mailDomains')->get()
                        ->each(function (System $system) {
                            SyncSystemDomains::dispatch($system);
                            SyncSystemDNS::dispatch($system);
                            SyncSystemDatabases::dispatch($system);
                            SyncSystemMailDomains::dispatch($system);
                        });
                })
                ->name('System data')
                ->dailyAt('3:00')
                ->withoutOverlapping();

            $schedule->job(new SyncSystemTemplates())
                ->name('System templates')
                ->dailyAt('3:00')
                ->withoutOverlapping();
        }

        /**
         * Register the commands for the application.
         *
         * @return void
         */
        protected function commands(): void
        {
            $this->load(__DIR__ . '/Console/Commands');

            require base_path('routes/console.php');
        }
    }
