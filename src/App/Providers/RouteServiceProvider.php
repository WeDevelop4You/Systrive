<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use stdClass;
use Symfony\Component\Finder\Finder;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * @var array
     */
    private array $routeConfigs;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->createRouteConfig();
    }

    public function map()
    {
        foreach ($this->routeConfigs as $routeConfig) {
            foreach ($routeConfig->files as $file) {
                $prefix = $this->generatePrefix($file->getRelativePath(), $routeConfig->prefix);

                Route::prefix($prefix)
                    ->name($routeConfig->name)
                    ->domain($routeConfig->domain)
                    ->middleware($routeConfig->middleware)
                    ->group($file->getRealPath());
            }
        }
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    private function createRouteConfig()
    {
        foreach (config('applications') as $application => $config) {
            $domain = $config['domain'] ?? null;

            $this->createWebRouteConfig($application, $domain);
            $this->createApiRouteConfig($application, $domain);
        }
    }

    /**
     * @param string      $application
     * @param string|null $domain
     */
    private function createWebRouteConfig(string $application, ?string $domain = null)
    {
        $route = new stdClass();

        $route->prefix = null;
        $route->domain = $domain;
        $route->middleware = 'web';
        $route->name = strtolower($application) . '.';
        $route->files = $this->getAllRouteFiles($application, 'web.php');

        $this->routeConfigs[] = $route;
    }

    /**
     * @param string      $application
     * @param string|null $domain
     */
    private function createApiRouteConfig(string $application, ?string $domain = null)
    {
        $route = new stdClass();

        $route->prefix = 'api';
        $route->domain = $domain;
        $route->middleware = 'api';
        $route->name = strtolower($application) . '.';
        $route->files = $this->getAllRouteFiles($application, 'api.php');

        $this->routeConfigs[] = $route;
    }

    /**
     * @param string $application
     * @param string $fileName
     *
     * @return Finder
     */
    private function getAllRouteFiles(string $application, string $fileName): Finder
    {
        $finder = new Finder();
        $path = sprintf('%s/../%s', __DIR__, ucfirst(strtolower($application)));

        return $finder->name($fileName)->in($path)->files();
    }

    /**
     * @param string      $path
     * @param string|null $prefix
     *
     * @return string
     */
    private function generatePrefix(string $path, ?string $prefix = null): string
    {
        $prefixes = [];
        $pathNames = explode('/', $path);

        foreach ($pathNames as $name) {
            $name = strtolower($name);

            if (!in_array($name, ['routes', 'auth'])) {
                $prefixes[] = Str::plural($name);

                if ((count($pathNames) - 1) > count($prefixes)) {
                    $prefixes[] = "{". Str::singular($name) ."}";
                }
            }
        }

        return implode('/', ($prefix ? [$prefix, ...$prefixes] : $prefixes));
    }
}
