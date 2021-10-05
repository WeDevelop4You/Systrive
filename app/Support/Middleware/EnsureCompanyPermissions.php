<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class EnsureCompanyPermissions
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        try {
            $company = $user->companies()->where('id', $request->route('company'))->firstOrFail();

            app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($company->id);

            return $next($request);
        } catch (ModelNotFoundException $e) {
            $response = new Response(ResponseCodes::HTTP_FORBIDDEN);
            $response->addPopup(trans('response.forbidden.company'));

            return $response->toJson();
        }
    }
}
