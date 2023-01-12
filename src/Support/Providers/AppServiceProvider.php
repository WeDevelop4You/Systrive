<?php

namespace Support\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use ReflectionException;
use Support\Helpers\ApplicationHelper;
use Support\Mixins\BuilderMixin;
use Support\Mixins\CollectionMixin;
use Support\Mixins\ConfigMixin;
use Support\Mixins\RelationMixin;

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
        ApplicationHelper::setDomain();

        Config::mixin(new ConfigMixin());
        Builder::mixin(new BuilderMixin());
        Relation::mixin(new RelationMixin());
        Collection::mixin(new CollectionMixin());
    }
}
