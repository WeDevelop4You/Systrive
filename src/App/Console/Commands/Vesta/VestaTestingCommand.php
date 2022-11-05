<?php

    namespace App\Console\Commands\Vesta;

    use Illuminate\Console\Command;
    use Support\Enums\VestaCommand;
    use Support\Services\Vesta;

    class VestaTestingCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'vesta:test';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'vesta command testing';

        /**
         * Execute the console command.
         *
         * @return int
         */
        public function handle(): int
        {
            $data = Vesta::api()->get(VestaCommand::GET_DNS_TEMPLATES);

            dd($data);

            return 1;
        }
    }
