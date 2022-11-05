<?php

namespace Domain\Cms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Support\Services\Cms as CmsService;

class InitialiseCmsDatabase
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        CmsService::findAndCreateConnection(
            $request->route()->parameter('cms')
        );

        return $next($request);
    }
}
