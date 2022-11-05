<?php

    namespace App\Console\Commands\Vesta;

    use Domain\System\Jobs\SyncSystemDatabases;
    use Domain\System\Jobs\SyncSystemDNS;
    use Domain\System\Jobs\SyncSystemDomains;
    use Domain\System\Jobs\SyncSystemMailDomains;
    use Domain\System\Models\System;
    use Domain\System\Models\SystemDatabase;
    use Domain\System\Models\SystemDNS;
    use Domain\System\Models\SystemDomain;
    use Domain\System\Models\SystemMailDomain;
    use Domain\System\Models\SystemUsageStatistic;
    use Illuminate\Console\Command;

    class VestaClearCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:clear';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'clear all vesta data';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            if ($this->confirm('Are you sure you want to clear all vesta data?')) {
                SystemUsageStatistic::truncate();
                SystemDomain::truncate();
                SystemDNS::truncate();
                SystemDatabase::truncate();
                SystemMailDomain::truncate();

                System::with('domains', 'dns', 'databases', 'mailDomains')->get()
                    ->each(function (System $system) {
                        SyncSystemDomains::dispatchSync($system);
                        SyncSystemDNS::dispatchSync($system);
                        SyncSystemDatabases::dispatchSync($system);
                        SyncSystemMailDomains::dispatchSync($system);
                    });

                $this->info('All the data is clear');
            }

            return 1;
        }
    }
