<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemUserDatabases;
    use Domain\System\Models\SystemUser;
    use Illuminate\Console\Command;

    class SyncDatabases extends Command
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
            SystemUser::with('domains')->get()
                ->each(function (SystemUser $systemUser) {
                    SyncSystemUserDatabases::dispatch($systemUser);
                });

            return 1;
        }
    }
