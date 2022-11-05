<?php

namespace App\Console\Commands\Generate;

use Illuminate\Console\Command;
use Support\Helpers\Application\RouteConstructor;

class GenerateApiCommand extends Command
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
    private array $routes;

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

        $this->routes = RouteConstructor::getApiRoutes($this->application)->toArray();

        if (!$this->generateFile()) {
            $this->error('No path or filename set in applications config');

            return 0;
        }

        $this->info('The file was successfully created');

        return 1;
    }

    /**
     * @return bool
     */
    private function generateFile(): bool
    {
        $path = config("applications.{$this->application}.api.store_path");
        $filename = config("applications.{$this->application}.api.filename");
        $output = stripslashes(json_encode($this->routes, JSON_PRETTY_PRINT));

        if (\is_null($path) || \is_null($filename)) {
            return false;
        }

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents("{$path}/{$filename}", $output);

        return true;
    }
}
