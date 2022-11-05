<?php

namespace Domain\Permission\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CompanyPermissionsMiddleware
{
    public function handle(Request $request, Closure $next, $permission, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        if ($authGuard->user()->hasPermission(...$permissions)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
