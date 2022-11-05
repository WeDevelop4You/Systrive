<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemDatabases;
    use Domain\System\Models\System;
    use Illuminate\Console\Command;

    class VestaSyncDatabasesCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:databases';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Sync databases from vesta';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            System::with('databases')->get()
                ->each(function (System $system) {
                    SyncSystemDatabases::dispatch($system);
                });

            return 1;
        }
    }
