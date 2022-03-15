<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystem;
    use Illuminate\Console\Command;

    class SyncSystemUsers extends Command
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
            SyncSystem::dispatch();

            return 1;
        }
    }
