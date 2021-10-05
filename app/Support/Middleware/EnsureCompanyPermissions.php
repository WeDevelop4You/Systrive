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
            $company = $request->route('company');
            $id = $company instanceof Company ? $company->id : $company;

            $user->companies()->where('id', $id)->firstOrFail();

            app(PermissionRegistrar::class)->setPermissionsTeamId($id);

            return $next($request);
        } catch (ModelNotFoundException $e) {
            $response = new Response(ResponseCodes::HTTP_FORBIDDEN);
            $response->addPopup(trans('response.forbidden.company'));

            return $response->toJson();
        }
    }
}
