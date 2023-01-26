<?php

namespace Support\Exceptions\Handlers;

use Domain\Company\Models\Company;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Support\Client\Actions\RouteAction;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Helpers\ApplicationHelper;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class UnauthorizedExceptionHandler extends Exception
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        $response = Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.user.not.allowed')))
            ->setStatusCode(ResponseCode::HTTP_FORBIDDEN);

        if (!$request->expectsJson()) {
            return $response->toSession()
                ->addRedirect(ApplicationHelper::getRedirectRoute())
                ->toRedirect();
        }

        if ($request->isMethod('GET')) {
            $response->addAction(RouteAction::create()->goTo($this->getRoute($request)));
        }

        return $response->toJson();
    }

    private function getRoute(Request $request): VueRouteHelper
    {
        if (ApplicationHelper::isAdminDomain()) {
            return VueRouteHelper::createDashboard();
        }

        if (ApplicationHelper::isAccountDomain()) {
            return VueRouteHelper::createAccountSettings();
        }

        if (!$request->route()->hasParameter('company')) {
            return VueRouteHelper::createSwitcher();
        }

        /** @var Company $company */
        $company = $request->route()->parameter('company');

        return VueRouteHelper::createCompany($company);
    }
}
