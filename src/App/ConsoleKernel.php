<?php

    namespace App;

    use Domain\Invite\Jobs\CheckInviteHasExpired;
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
                 ->runInBackground()
                 ->everyFiveMinutes()
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
