<?php

    namespace App\Console\Commands\Supervisor;

    use Domain\Supervisor\Jobs\SyncSupervisorConfigs;
    use Illuminate\Console\Command;

    class SupervisorConfigsCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'supervisor:configs';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'sync all supervisor configs';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            SyncSupervisorConfigs::dispatchSync();

            return 1;
        }
    }
