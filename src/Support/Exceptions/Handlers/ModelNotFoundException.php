<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Action\Methods\RouteMethod;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class ModelNotFoundException extends Exception
    {
        /**
         * @var bool
         */
        public bool $lastRouteAction = false;

        /**
         * @param $request
         *
         * @return false|JsonResponse
         */
        public function render($request): bool|JsonResponse
        {
            if ($request->is('api/*') && $request->routeIs('admin.*')) {
                $response = new Response(ResponseCodes::HTTP_NOT_FOUND);

                switch ($request->getMethod()) {
                    case 'DELETE':
                        $response->addPopup(trans('response.error.model.delete'));

                        break;
                    default:
                        $response->addPopup(trans('response.error.model.not.found'));

                        $this->lastRouteAction
                            ? $response->addAction(RouteMethod::create())->goToLastRoute()
                            : $response->addAction(RouteMethod::create())->goToMainRoute();
                }

                return $response->toJson();
            }

            return false;
        }
    }
