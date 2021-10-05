<?php

namespace App\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route as RouteList;
use Illuminate\Support\Str;

class ApiRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-routes {application}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new file with all api routes';

    /**
     * @var Collection
     */
    private Collection $routes;

    /**
     * @var array
     */
    private array $apiRoutes;

    /**
     * @var string
     */
    private string $application;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->routes = new Collection();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->application = strtolower($this->argument('application'));

        $this->create();

        $this->info('The file was successfully created');

        return 1;
    }

    /**
     * @return Collection
     */
    private function getRoutes(): Collection
    {
        return new Collection(RouteList::getRoutes());
    }

    private function findApiRoutes(): void
    {
        self::getRoutes()->each(function (Route $route) {
            if (in_array('api', $route->getAction('middleware')) && Str::startsWith($route->getName(), "{$this->application}.")) {
                $this->routes->push($route);
            }
        });
    }

    private function setToFile(): void
    {
        $file = 'api.json';
        $path = App::resourcePath("{$this->application}/js/config");
        $output = stripslashes(json_encode($this->apiRoutes, JSON_PRETTY_PRINT));

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        file_put_contents("{$path}/{$file}", $output);
    }

    public function create(): void
    {
        $this->findApiRoutes();

        $this->apiRoutes = $this->routes->mapWithKeys(function(Route $route, $index) {
            $name = $route->getName() ?: "no_name_{$index}";
            $uri = '/' . trim($route->uri(), '/');

            return [$name => $uri];
        })->toArray();

        $this->setToFile();
    }
}
