<?php

namespace Support\Middleware;

use Closure;
use Domain\Company\Models\Company;
use Domain\User\Models\UserInvite;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\PermissionRegistrar;
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

            app(PermissionRegistrar::class)->setPermissionsTeamId(0);

            if (!$user->hasRole('super_admin') && $this->hasCompanyParameter($request)) {
                try {
                    $query = $user->companies();
                    $parameter = $this->getCompanyParameter($request);

                    is_string($parameter)
                        ? $query->where('name', $parameter)
                        : $query->wherePivot('company_id', $parameter);

                    if (!$request->routeIs(self::IGNORE_USER_ACCEPTED_ROUTES)) {
                        $query->wherePivot('status', UserInvite::INVITE_USER_ACCEPTED);
                    }

                    $company = $query->firstOrFail();

                    app(PermissionRegistrar::class)->setPermissionsTeamId($company->id);
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

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function hasCompanyParameter(Request $request): bool
    {
        return $request->route()->hasParameter('company') ||
            $request->route()->hasParameter('companyName');
    }

    private function getCompanyParameter(Request $request): int|string
    {
        if ($request->route()->hasParameter('companyName')) {
            return (string) $request->route('companyName');
        }

        $company = $request->route('company');

        return (int) ($company instanceof Company ? $company->id : $company);
    }
}
