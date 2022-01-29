<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemUserDNS;
    use Domain\System\Models\SystemUser;
    use Illuminate\Console\Command;

    class SyncDomainNameServers extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:dns';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Sync domain name servers from vesta';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            SystemUser::with('domains')->get()
                ->each(function (SystemUser $systemUser) {
                    SyncSystemUserDNS::dispatch($systemUser);
                });

            return 1;
        }
    }
