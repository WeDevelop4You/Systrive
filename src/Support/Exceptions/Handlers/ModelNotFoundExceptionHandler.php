<?php

namespace Support\Exceptions\Handlers;

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

class ModelNotFoundExceptionHandler extends Exception
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        $response = Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.error.model.not.found')),
            ResponseCode::HTTP_NOT_FOUND
        );

        if ($request->expectsJson()) {
            switch ($request->getMethod()) {
                case 'DELETE':
                    $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.model.delete')));

                    break;
                case 'GET':
                    if (ApplicationHelper::isCompanyDomain() && $request->routeIs('company.search')) {
                        $response->addAction(RouteAction::create()->goTo(VueRouteHelper::createSwitcher()))
                            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.company.not.found')));

                        break;
                    }
            }

            return $response->toJson();
        }

        return $response->toSession()
            ->addRedirect(ApplicationHelper::getRedirectRoute())
            ->toRedirect();
    }
}
