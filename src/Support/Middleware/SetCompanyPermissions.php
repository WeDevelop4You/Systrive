<?php

namespace Support\Middleware;

use Closure;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class SetCompanyPermissions
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return string|null
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $request->routeIs('admin.company*') && $request->route()->hasParameter('company')) {
            $company = $request->route('company');
            $id = $company instanceof Company ? $company->id : $company;

            try {
                Auth::user()->companies()->wherePivot('company_id', $id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $response = new Response(ResponseCodes::HTTP_FORBIDDEN);
                $response->addPopup(trans('response.forbidden.company'));

                return $response->toJson();
            }
        }

        app(PermissionRegistrar::class)->setPermissionsTeamId($id ?? 0);

        return $next($request);
    }
}
