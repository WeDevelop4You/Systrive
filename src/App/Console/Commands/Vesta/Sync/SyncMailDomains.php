<?php

    namespace App\Console\Commands\Vesta\Sync;

    use Domain\System\Jobs\SyncSystemUserMailDomains;
    use Domain\System\Models\SystemUser;
    use Illuminate\Console\Command;

    class SyncMailDomains extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:mails';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Sync mail domains from vesta';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            SystemUser::with('domains')->get()
                ->each(function (SystemUser $systemUser) {
                    SyncSystemUserMailDomains::dispatch($systemUser);
                });

            return 1;
        }
    }
