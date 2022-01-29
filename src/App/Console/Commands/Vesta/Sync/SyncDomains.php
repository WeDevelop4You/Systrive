<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemUserDomains;
    use Domain\System\Models\SystemUser;
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
            SystemUser::with('domains')->get()
                ->each(function (SystemUser $systemUser) {
                    SyncSystemUserDomains::dispatch($systemUser);
                });

            return 1;
        }
    }
