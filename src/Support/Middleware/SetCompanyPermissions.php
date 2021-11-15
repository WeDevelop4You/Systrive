<?php

namespace Support\Middleware;

use Closure;
use Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $user = Auth::user();

            setPermissionsTeamId(0);

            if ($request->route()->hasParameter('company') && !$user->hasRole('super_admin')) {
                $company = $request->route('company');
                $id = $company instanceof Company ? $company->id : $company;

                try {
                    $user->companies()->wherePivot('company_id', $id)->firstOrFail();
                } catch (ModelNotFoundException) {
                    $response = new Response(ResponseCodes::HTTP_FORBIDDEN);
                    $response->addPopup(trans('response.forbidden.company'));

                    return $response->toJson();
                }

                setPermissionsTeamId($id);
            }
        }

        return $next($request);
    }
}
