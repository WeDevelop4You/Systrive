<?php

    namespace App\Exceptions\Handlers;

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
        public function render($request)
        {
            if ($request->is('api/*') && $request->routeIs('admin.*')) {
                $response = new Response(ResponseCodes::HTTP_FORBIDDEN);
                $response->addPopup(trans('response.error.user.not_allowed'));
                $response->addAction(RouteMethod::create())->setActionGoToLastRoute();

                return $response->toJson();
            }

            return false;
        }
    }
