<?php

    namespace App\Exceptions\Handlers;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Action\Methods\RouteMethod;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class ModelNotFoundException extends Exception
    {
        /**
         * @param $request
         *
         * @return false|JsonResponse
         */
        public function render($request)
        {
            if ($request->is('api/*') && $request->routeIs('admin.*')) {
                $response = new Response(ResponseCodes::HTTP_NOT_FOUND);

                switch ($request->getMethod()) {
                    case 'DELETE':
                        $response->addPopup(trans('response.error.model.delete'));

                        break;
                    default:
                        $response->addPopup(trans('response.error.model.not_found'));
                        $response->addAction(RouteMethod::create())->setActionGoToLastRoute();
                }

                return $response->toJson();
            }

            return false;
        }
    }
