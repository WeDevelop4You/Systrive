<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Action\Methods\RouteMethod;
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
                $response = new Response(ResponseCodes::HTTP_FORBIDDEN);
                $response->addPopup(trans('response.error.user.not.allowed'));
                $response->addAction(RouteMethod::create())->goToLastRoute();

                return $response->toJson();
            }

            return false;
        }
    }
