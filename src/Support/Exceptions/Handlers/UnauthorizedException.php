<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Action\Methods\RouteMethod;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class UnauthorizedException extends Exception
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
                    ->addAction(RouteMethod::create()->goToLastRoute())
                    ->addPopup(new SimpleNotification(trans('response.error.user.not.allowed')))
                    ->setStatusCode(ResponseCodes::HTTP_FORBIDDEN)
                    ->toJson();
            }

            return false;
        }
    }
