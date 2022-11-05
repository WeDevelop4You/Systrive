<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Actions\RouteAction;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class UnauthorizedExceptionHandler extends Exception
    {
        /**
         * @param $request
         *
         * @return false|JsonResponse
         */
        public function render($request): bool|JsonResponse
        {
            if ($request->is('api/*') && $request->routeIs('admin.*')) {
                return Response::create()
                    ->addAction(RouteAction::create()->goToLastRoute())
                    ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.user.not.allowed')))
                    ->setStatusCode(ResponseCode::HTTP_FORBIDDEN)
                    ->toJson();
            }

            return false;
        }
    }
