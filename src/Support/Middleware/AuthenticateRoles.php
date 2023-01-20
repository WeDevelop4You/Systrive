<?php

namespace Support\Middleware;

use Closure;
use Domain\Company\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateRoles
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
        if (Auth::check()) {
            setCompanyId();

            if (! Auth::user()->isSuperAdmin() && $request->route()->hasParameter('company')) {
                $company = $request->route()->parameter('company');

                setCompanyId($company instanceof Company ? $company->id : $company);
            }

            Auth::user()->load('roles');
        }

        return $next($request);
    }
}
