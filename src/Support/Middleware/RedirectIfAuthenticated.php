<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\Helpers\ApplicationHelper;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request     $request
     * @param Closure     $next
     * @param string|null ...$guards
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards): mixed
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $route = match ($request->route()->getDomain()) {
                    ApplicationHelper::getAdminDomain() => ApplicationHelper::getAdminRoute(),
                    ApplicationHelper::getCompanyDomain() => ApplicationHelper::getSwitcherRoute(),
                    ApplicationHelper::getAccountDomain() => ApplicationHelper::getSettingsRoute(),
                };

                return redirect($route);
            }
        }

        return $next($request);
    }
}
