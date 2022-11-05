<?php

namespace Domain\Cms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Support\Services\Cms;

class InitialiseCmsTable
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @param Closure $next
     * @param string  $key
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $key = 'id'): mixed
    {
        Cms::findAndSetTable(
            $request->route()->parameter('table'),
            $key
        );

        return $next($request);
    }
}
