<?php

    namespace Support\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Support\Response\Actions\RouteAction;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class ModelNotFoundExceptionHandler extends Exception
    {
        /**
         * @param Request $request
         *
         * @return false|JsonResponse
         */
        public function render(Request $request): bool|JsonResponse
        {
//            if ($request->is('api/*') && $request->routeIs('admin.*')) {
            $response = new Response();

            switch ($request->getMethod()) {
                case 'DELETE':
                    $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.model.delete')));

                    break;
                case 'GET':
                    $lastRouteName = $request->header('X-Last-Route-Name', '');

                    if (Str::startsWith($lastRouteName, ['company.'])) {
                        $response->addAction(RouteAction::create()->goToDashboard());
                    }
                    // no break
                default:
                    $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.model.not.found')));
            }

            return $response->setStatusCode(ResponseCode::HTTP_NOT_FOUND)->toJson();
//            }
//
//            return false;
        }
    }
