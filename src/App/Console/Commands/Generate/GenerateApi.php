<?php

namespace App\Console\Commands\Generate;

use function config;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteList;
use Illuminate\Support\Str;

class GenerateApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api {application}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a file with all the api routes';

    /**
     * @var array
     */
    private array $apiRoutes;

    /**
     * @var string
     */
    private string $application;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->application = strtolower($this->argument('application'));

        $this->findRoutes();

        if (!$this->generateFile()) {
            $this->error('No path or filename set in applications config');

            return 0;
        }

        $this->info('The file was successfully created');

        return 1;
    }

    private function findRoutes(): void
    {
        $routeList = new Collection(RouteList::getRoutes());

        $this->apiRoutes = $routeList->mapWithKeys(function (Route $route, int $index) {
            if (in_array('api', $route->getAction('middleware')) &&
                Str::startsWith($route->getName(), "{$this->application}.")
            ) {
                $name = $route->getName() ?: "no_name_{$index}";
                $uri = '/' . trim($route->uri(), '/');

                return [$name => $uri];
            }

            return [];
        })->toArray();
    }

    /**
     * @return bool
     */
    private function generateFile(): bool
    {
        $path = config("applications.{$this->application}.api.store_path");
        $filename = config("applications.{$this->application}.api.filename");
        $output = stripslashes(json_encode($this->apiRoutes, JSON_PRETTY_PRINT));

        if (is_null($path) || is_null($filename)) {
            return false;
        }

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents("{$path}/{$filename}", $output);

        return true;
    }
}
