<?php

namespace Support\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Finder\Finder;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureBindings();
        $this->createDataTableMacro();
        $this->configureRateLimiting();

        Config::collect('applications')->eachCollect(function(Collection $config, string $application) {
            $this->load(
                $config->getCollect('routes'),
                $config->get('path'),
                $application
            );
        });
    }

    /**
     * @return void
     */
    private function configureBindings(): void
    {
        Route::bind('uuid', function ($value) {
            return Uuid::fromString($value);
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return App::isLocal()
                ? Limit::none()
                : Limit::perMinute(100)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * @return void
     */
    private function createDataTableMacro(): void
    {
        if (Route::hasMacro('dataTable')) {
            return;
        }

        Route::macro('dataTable', function (string $controller, string $name, string $prefix = '') {
            Route::prefix("{$prefix}/table")->controller($controller)->group(function () use ($name) {
                Route::get('items', 'action')->name("{$name}.table.items");
                Route::get('headers', 'index')->name("{$name}.table.headers");
            });
        });
    }

    /**
     * @param Collection $config
     * @param string     $path
     * @param string     $application
     *
     * @return void
     */
    private function load(Collection $config, string $path, string $application): void
    {
        $domain = $config->get('domain');
        $plurals = $config->get('plurals', []);
        $name = Str::of($application)->lower()->append('.');

        $route = Route::domain($domain)->name($name);

        $config->getCollect('files')->eachCollect(function(Collection $config) use ($path, $plurals, $route) {
            $filename = $config->get('filename');
            $middleware = $config->get('middleware');
            $additional = $config->get('prefix', '');

            $files = Finder::create()
                ->in($path)
                ->name($filename)
                ->files();

            foreach ($files as $file) {
                $prefix = $this->createPrefix(
                    $file->getRelativePath(),
                    $additional,
                    $plurals
                );

                $route->prefix($prefix)
                    ->middleware($middleware)
                    ->group($file->getRealPath());
            }
        });
    }

    /**
     * @param string $path
     * @param string $additional
     * @param array  $plurals
     *
     * @return string
     */
    private function createPrefix(string $path, string $additional, array $plurals): string
    {
        return Str::of($path)
            ->dirname()
            ->split('/\//')
            ->map(function(string $name) use ($plurals) {
                $name = Str::lower($name);

                return Arr::get($plurals, $name, Str::plural($name));
            })
            ->prepend($additional)
            ->filter()
            ->implode('/');
    }
}
