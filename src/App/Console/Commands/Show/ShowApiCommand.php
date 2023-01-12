<?php

namespace App\Console\Commands\Show;

use Illuminate\Console\Command;
use Support\Helpers\RouteHelper;

class ShowApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:api {application}';

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
        $application = strtolower($this->argument('application'));

        $this->newLine();
        $this->components->twoColumnDetail(
            '<fg=green;options=bold>Name</>',
            '<fg=green;options=bold>URI</>'
        );

        RouteHelper::getApiRoutes($application)
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
