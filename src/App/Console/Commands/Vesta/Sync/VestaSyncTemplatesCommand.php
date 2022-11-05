<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemTemplates;
    use Illuminate\Console\Command;

    class VestaSyncTemplatesCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:templates';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Sync system templates from vesta';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            SyncSystemTemplates::dispatch();

            return 1;
        }
    }
