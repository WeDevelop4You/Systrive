<?php

    namespace Support\Helpers\Response;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Resources\Json\ResourceCollection;
    use Support\Helpers\Response\Action\ActionContent;
    use Support\Helpers\Response\Action\ActionMethodBase;
    use Support\Helpers\Response\Popup\PopupContent;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class Response
    {
        /**
         * @var array|JsonResource|ResourceCollection
         */
        private JsonResource|array|ResourceCollection $data;

        /**
         * @var int
         */
        private int $statusCode;

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
         * @param int $statusCode
         */
        public function __construct(int $statusCode = ResponseCodes::HTTP_OK)
        {
            $this->statusCode = $statusCode;
        }

        /**
         * @param int $statusCode
         *
         * @return Response
         */
        public static function create(int $statusCode = ResponseCodes::HTTP_OK): Response
        {
            return new static($statusCode);
        }

        /**
         * @param $statusCode
         *
         * @return Response
         */
        public function setStatusCode($statusCode): Response
        {
            $this->statusCode = $statusCode;

            if (isset($this->popup)) {
                $this->popup->message->selectedTypeByStatusCode($statusCode);
            }

            return $this;
        }

        /**
         * @param string     $key
         * @param array|null $errors
         * @param int        $statusCode
         *
         * @return Response
         */
        public function addErrors(string $key, ?array $errors = null, int $statusCode = ResponseCodes::HTTP_BAD_REQUEST): Response
        {
            $this->statusCode = $statusCode;

            if (is_null($errors)) {
                $this->errors = array_merge($this->errors, $key);
            } else {
                $this->errors[$key] = array_merge($this->errors[$key] ?? [], $errors);
            }

            return $this;
        }

        /**
         * @param $data
         * @param string|null $resourceClass
         * @param bool        $collection
         *
         * @return array|JsonResource|ResourceCollection
         */
        public function addData($data, ?string $resourceClass = null, bool $collection = false): ResourceCollection|array|JsonResource
        {
            $this->data = is_null($resourceClass)
                ? $data
                : (
                    $collection
                    ? call_user_func([$resourceClass, 'collection'], $data)
                    : new $resourceClass($data)
                );

            return $this->data;
        }

        /**
         * @param string $message
         * @param string $component
         *
         * @return PopupContent
         */
        public function addPopup(string $message, string $component = PopupContent::SIMPLE_TYPE): PopupContent
        {
            $this->popup = new PopupContent($message, $this->statusCode, $component);

            return $this->popup;
        }

        /**
         * @param ActionMethodBase $methodClass
         *
         * @return ActionMethodBase
         */
        public function addAction(ActionMethodBase $methodClass): ActionMethodBase
        {
            $this->action = new ActionContent($methodClass);

            return $this->action->getMethod();
        }

        public function addRedirect(string $route)
        {
            $this->redirect = $route;
        }

        /**
         * @return JsonResponse
         */
        public function toJson(): JsonResponse
        {
            return response()->json($this->createResponseContent(), $this->statusCode);
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
                $response['popup'] = $this->popup->create();
            }

            if (isset($this->action)) {
                $response['action'] = $this->action->create();
            }

            if (isset($this->redirect)) {
                $response['redirect'] = $this->redirect;
            }

            return $response;
        }
    }
