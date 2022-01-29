<?php

    namespace Support\Helpers\Response;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Illuminate\Support\Facades\Session;
    use Support\Helpers\Response\Action\ActionContent;
    use Support\Helpers\Response\Action\ActionMethodBase;
    use Support\Helpers\Response\Popups\Notifications\NotificationBase;
    use Support\Helpers\Response\Popups\PopupBase;
    use Support\Helpers\Response\Popups\PopupContent;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class Response
    {
        public const SESSION_KEY_DEFAULT = 'responseData';
        public const SESSION_KEY_MODAL = 'responseDataModal';
        public const SESSION_KEY_REGISTRATION = 'registrationData';
        /**
         * @var array|JsonResource|ResourceCollection
         */
        private JsonResource|array|ResourceCollection $data;

        /**
         * @var int
         */
        private int $statusCode = ResponseCodes::HTTP_OK;

        /**
         * @var array
         */
        private array $errors = [];

        /**
         * @var PopupContent
         */
        private PopupContent $popup;

        /**
         * @var ActionContent
         */
        private ActionContent $action;

        /**
         * @var string
         */
        private string $redirect;

        /**
         * @return Response
         */
        public static function create(): Response
        {
            return new static();
        }

        /**
         * @param $statusCode
         *
         * @return Response
         */
        public function setStatusCode($statusCode): Response
        {
            $this->statusCode = $statusCode;

            if (isset($this->popup) && $this->popup->instance instanceof NotificationBase) {
                $this->popup->instance->selectedTypeByStatusCode($statusCode);
            }

            return $this;
        }

        /**
         * @param array|string $key
         * @param array|null   $errors
         * @param int          $statusCode
         *
         * @return Response
         */
        public function addErrors(string|array $key, ?array $errors = null, int $statusCode = ResponseCodes::HTTP_BAD_REQUEST): Response
        {
            $this->setStatusCode($statusCode);

            if (is_null($errors)) {
                $this->errors = array_merge($this->errors, $key);
            } else {
                $this->errors[$key] = array_merge($this->errors[$key] ?? [], $errors);
            }

            return $this;
        }

        /**
         * @param AnonymousResourceCollection|array|JsonResource $data
         *
         * @return Response
         */
        public function addData(AnonymousResourceCollection|array|JsonResource $data): Response
        {
            $this->data = $data;

            return $this;
        }

        /**
         * @param PopupBase $instance
         * @param int|null  $statusCode
         *
         * @return Response
         */
        public function addPopup(PopupBase $instance, ?int $statusCode = null): Response
        {
            $this->popup = new PopupContent($instance);

            $this->setStatusCode($statusCode ?: $this->statusCode);

            return $this;
        }

        /**
         * @param ActionMethodBase $methodClass
         *
         * @return Response
         */
        public function addAction(ActionMethodBase $methodClass): Response
        {
            $this->action = new ActionContent($methodClass);

            return $this;
        }

        /**
         * @param string $route
         *
         * @return Response
         */
        public function addRedirect(string $route): Response
        {
            $this->redirect = $route;

            return $this;
        }

        /**
         * @return array
         */
        public function createResponseContent(): array
        {
            $response = [];

            if (!empty($this->errors)) {
                $response['errors'] = $this->errors;
            }

            if (isset($this->data)) {
                $response['data'] = $this->data;
            }

            if (isset($this->popup)) {
                $response['popup'] = $this->popup->getData();
            }

            if (isset($this->action)) {
                $response['action'] = $this->action->getData();
            }

            if (isset($this->redirect)) {
                $response['redirect'] = $this->redirect;
            }

            return $response;
        }

        /**
         * @return JsonResponse
         */
        public function toJson(): JsonResponse
        {
            return response()->json($this->createResponseContent(), $this->statusCode);
        }

        /**
         * @param string $key
         *
         * @return void
         */
        public function toSession(string $key = self::SESSION_KEY_DEFAULT): void
        {
            Session::put($key, $this->createResponseContent());
        }

        /**
         * @param string $key
         *
         * @return mixed
         */
        public static function getSessionData(string $key = self::SESSION_KEY_MODAL): mixed
        {
            return Session::get("{$key}.data");
        }
    }
