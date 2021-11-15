<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\App;
    use Support\Helpers\Response\Action\Methods\RouteMethod;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class QueryException extends Exception
    {
        /**
         * @param $request
         *
         * @return false|JsonResponse
         */
        public function render($request): bool|JsonResponse
        {
            if (App::isProduction()) {
                $response = new Response(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR);
                $response->addPopup(trans('response.error.server'));

                return $response->toJson();
            }

            return false;
        }
    }
