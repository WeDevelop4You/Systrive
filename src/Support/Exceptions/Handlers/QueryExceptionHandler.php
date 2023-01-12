<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\App;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class QueryExceptionHandler extends Exception
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
                    ->setStatusCode(ResponseCode::HTTP_INTERNAL_SERVER_ERROR)
                    ->toJson();
            }

            return false;
        }
    }
