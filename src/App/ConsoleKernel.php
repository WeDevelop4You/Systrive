<?php

    namespace App;

    use Domain\Invite\Jobs\CheckInviteHasExpired;
    use Domain\System\Jobs\SyncSystemUserDatabases;
    use Domain\System\Jobs\SyncSystemUserDNS;
    use Domain\System\Jobs\SyncSystemUserDomains;
    use Domain\System\Jobs\SyncSystemUserMailDomains;
    use Domain\System\Jobs\SyncSystemUsers;
    use Domain\System\Models\SystemUser;
    use Illuminate\Console\Scheduling\Schedule;
    use Illuminate\Foundation\Console\Kernel;
    use Illuminate\Support\Facades\Bus;
    use Illuminate\Support\Facades\Log;

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

            $schedule->job(new SyncSystemUsers())
                ->then(function (Schedule $schedule) {
                    SystemUser::all()->each(function (SystemUser $systemUser) {
                        Bus::chain([
                            new SyncSystemUserDomains($systemUser),
                            new SyncSystemUserDNS($systemUser),
                            new SyncSystemUserDatabases($systemUser),
                            new SyncSystemUserMailDomains($systemUser),
                        ])->dispatch();
                    });
                })
                ->name('System user data')
                ->dailyAt('3:00')
                ->withoutOverlapping()
                ->emailOutputOnFailure('pmhuberts@gmail.com');

            if (env('TESTING', false)) {
                $schedule->call(function () {
                    Log::notice('Schedule is working');
                })->everyMinute();
            }
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
