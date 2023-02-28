<?php

namespace Support\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Domain\Api\Models\ApiAccessToken;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
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

        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(ApiAccessToken::class);

        ApplicationHelper::setDomain();

        Config::mixin(new ConfigMixin());
        Builder::mixin(new BuilderMixin());
        Relation::mixin(new RelationMixin());
        Collection::mixin(new CollectionMixin());

//        Log::info('Booted');
//
//        DB::listen(function ($query) {
//            Log::info($query->sql);
//        });
    }
}
