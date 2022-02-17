<?php

namespace Support\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Support\Helpers\Application\ComponentConstructor;
use Support\Helpers\Application\RouterConstructor;
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
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
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
            RouterConstructor::create(Collection::make($config->get('routes')), $application);
        });
    }
}
