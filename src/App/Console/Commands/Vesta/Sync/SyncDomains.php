<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemDomains;
    use Domain\System\Models\System;
    use Illuminate\Console\Command;

    class SyncDomains extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:domains';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Sync domains from vesta';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            System::with('domains')->get()
                ->each(function (System $system) {
                    SyncSystemDomains::dispatch($system);
                });

            return 1;
        }
    }
