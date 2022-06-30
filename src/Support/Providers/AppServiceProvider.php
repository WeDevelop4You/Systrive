<?php

namespace Support\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Support\Helpers\Application\ComponentConstructor;
use Support\Helpers\Application\RouteConstructor;
use Support\Helpers\Application\ViewConstructor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        if (!Route::hasMacro('dataTable')) {
            RouteConstructor::createDataTableMacro();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Collection::make(config('applications'))->each(function (array $config, string $application) {
            $config = Collection::make($config);
            $application = strtolower($application);

            ViewConstructor::create($this->app, $application);
            ComponentConstructor::create($this->app, $application);
            RouteConstructor::create(Collection::make($config->get('routes')), $application);
        });
    }
}
