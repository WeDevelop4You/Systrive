<?php

namespace Support\Middleware;

use Closure;
use Domain\Company\Mappings\CompanyUserTableMap;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class SetCompanyPermissions
{
    private const IGNORE_USER_ACCEPTED_ROUTES = [
        'admin.company.user.invite.accepted',
    ];

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
            setCompanyId();

            if (!$user->hasRole('super_admin') && $request->route()->hasParameter('company')) {
                try {
                    $company = $request->route('company');
                    $query = $user->companies()->wherePivot('company_id', $company->id);

                    if (!$request->routeIs(self::IGNORE_USER_ACCEPTED_ROUTES)) {
                        $query->wherePivot(
                            CompanyUserTableMap::STATUS,
                            CompanyUserTableMap::ACCEPTED_STATUS
                        );
                    }

                    $query->firstOrFail();

                    setCompanyId($company->id);
                } catch (ModelNotFoundException) {
                    return Response::create()
                        ->addPopup(new SimpleNotification(trans('response.forbidden.company')))
                        ->setStatusCode(ResponseCodes::HTTP_FORBIDDEN)
                        ->toJson();
                }
            }

            $user->load('roles');
        }

        return $next($request);
    }
}
