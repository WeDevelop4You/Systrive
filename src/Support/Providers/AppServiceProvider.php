<?php

namespace Support\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use ReflectionException;
use Support\Helpers\Application\ComponentConstructor;
use Support\Helpers\Application\RouteConstructor;
use Support\Helpers\Application\BladeConstructor;
use Support\Mixins\BuilderMixin;
use Support\Mixins\CallbackEventMixin;
use Support\Mixins\RelationMixin;
use Support\Mixins\ScheduleMixin;

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
     * @throws ReflectionException
     *
     * @return void
     */
    public function boot(): void
    {
        Builder::mixin(new BuilderMixin());
        Relation::mixin(new RelationMixin());
        Schedule::mixin(new ScheduleMixin());
        CallbackEvent::mixin(new CallbackEventMixin());

        Collection::make(config('applications'))->each(function (array $config, string $application) {
            $application = strtolower($application);

            BladeConstructor::create($this->app, $application);
            RouteConstructor::create(Collection::make(Arr::get($config, 'routes')), $application);
        });
    }
}
