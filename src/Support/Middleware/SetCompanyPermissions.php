<?php

namespace Support\Middleware;

use Closure;
use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
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

            if (!$user->isSuperAdmin() && $request->route()->hasParameter('company')) {
                try {
                    $company = $request->route()->parameter('company');
                    $id = $company instanceof Company ? $company->id : $company;

                    $query = $user->companies()->wherePivot(CompanyUserTableMap::COMPANY_ID, $id);

                    if (!$request->routeIs(self::IGNORE_USER_ACCEPTED_ROUTES)) {
                        $query->wherePivot(
                            CompanyUserTableMap::STATUS,
                            CompanyUserStatusTypes::ACCEPTED->value
                        );
                    }

                    $query->firstOrFail();

                    setCompanyId($id);
                } catch (ModelNotFoundException) {
                    return Response::create()
                        ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.forbidden.company')))
                        ->setStatusCode(ResponseCodes::HTTP_FORBIDDEN)
                        ->toJson();
                }
            }

            $user->load('roles');
        }

        return $next($request);
    }
}
