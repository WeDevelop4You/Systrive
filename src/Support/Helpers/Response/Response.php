<?php

    namespace Support\Helpers\Response;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Illuminate\Support\Facades\Session;
    use Support\Abstracts\Response\AbstractAction;
    use Support\Abstracts\Response\AbstractPopup;
    use Support\Abstracts\Response\NotificationAbstract;
    use Support\Enums\SessionKeyTypes;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class Response
    {
        /**
         * @var array|JsonResource|ResourceCollection|string
         */
        private JsonResource|array|string|ResourceCollection $data;

        /**
         * @var int
         */
        private int $statusCode = ResponseCodes::HTTP_OK;

        /**
         * @var array
         */
        private array $errors = [];

        /**
         * @var AbstractPopup
         */
        private AbstractPopup $popup;

        /**
         * @var AbstractAction
         */
        private AbstractAction $action;

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

            if (isset($this->popup) && $this->popup instanceof NotificationAbstract) {
                $this->popup->selectedTypeByStatusCode($statusCode);
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
         * @param AnonymousResourceCollection|array|JsonResource|string $data
         *
         * @return Response
         */
        public function addData(AnonymousResourceCollection|array|string|JsonResource $data): Response
        {
            $this->data = $data;

            return $this;
        }

        /**
         * @param AbstractPopup $popup
         * @param int|null      $statusCode
         *
         * @return Response
         */
        public function addPopup(AbstractPopup $popup, ?int $statusCode = null): Response
        {
            $this->popup = $popup;

            $this->setStatusCode($statusCode ?: $this->statusCode);

            return $this;
        }

        /**
         * @param AbstractAction $action
         *
         * @return Response
         */
        public function addAction(AbstractAction $action): Response
        {
            $this->action = $action;

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
                $response['popup'] = $this->popup->export();
            }

            if (isset($this->action)) {
                $response['action'] = $this->action->export();
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
         * @param SessionKeyTypes $key
         *
         * @return void
         */
        public function toSession(SessionKeyTypes $key = SessionKeyTypes::ONCE): void
        {
            Session::put($key->value, $this->createResponseContent());
        }

        /**
         * @param SessionKeyTypes $key
         *
         * @return mixed
         */
        public static function getSessionData(SessionKeyTypes $key = SessionKeyTypes::KEEP): mixed
        {
            return Session::get("{$key->value}.data");
        }
    }
