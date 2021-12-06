<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\App;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
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
                return Response::create()
                    ->addPopup(new SimpleNotification(trans('response.error.server')))
                    ->setStatusCode(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR)
                    ->toJson();
            }

            return false;
        }
    }
