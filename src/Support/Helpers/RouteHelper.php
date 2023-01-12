<?php

namespace Support\Helpers;

use Illuminate\Routing\Route as Routes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteHelper
{
    /**
     * @param string|null $application
     *
     * @return Collection
     */
    public static function getApiRoutes(?string $application = null): Collection
    {
        return Collection::make(Route::getRoutes())
            ->mapWithKeys(function (Routes $route, int $index) use ($application) {
                $isApi = \in_array('api', $route->getAction('middleware') ?: []);
                $allowed = \is_null($application) || Str::startsWith($route->getName(), "{$application}.");

                if ($isApi && $allowed) {
                    $name = $route->getName() ?: "no_name_{$index}";

                    return [$name => Str::start($route->uri(), '/')];
                }

                return [];
            });
    }
}
