<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Support\Helpers\RouteHelper;

class RouteShowApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:api {application? : show the api routes from a application}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all the api routes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->newLine();
        $this->components->twoColumnDetail(
            '<fg=green;options=bold>Name</>',
            '<fg=green;options=bold>URI</>'
        );

        RouteHelper::getApiRoutes($this->argument('application'))
            ->sortKeys()
            ->each(function ($uri, $name) {
                $this->components->twoColumnDetail(
                    $name,
                    preg_replace('#({[^}]+})#', '<fg=yellow>$1</>', $uri)
                );
            });

        $this->newLine();

        return 1;
    }
}
