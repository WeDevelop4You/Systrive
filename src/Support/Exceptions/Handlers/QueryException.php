<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\App;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
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
                    ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.server')))
                    ->setStatusCode(ResponseCodes::HTTP_INTERNAL_SERVER_ERROR)
                    ->toJson();
            }

            return false;
        }
    }
