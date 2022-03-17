<?php

    namespace App\Console\Commands\Vesta;

    use Illuminate\Console\Command;
    use Support\Enums\VestaCommands;
    use Support\Helpers\Vesta\VestaAPIHelper;

    class VestaTesting extends Command
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
            $data = VestaAPIHelper::create()->getCommand(VestaCommands::GET_USER_MAIL_DOMAIN, 'WeDevelop4You', 'wedevelop4you.nl');

            dd($data);

            return 1;
        }
    }
