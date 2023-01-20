<?php

namespace Support\Client;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response as ResponseConstructor;
use Illuminate\Support\Facades\Session;
use Support\Client\Actions\Action;
use Support\Client\Components\Component;
use Support\Client\Components\Popups\AbstractPopupComponent;
use Support\Client\Components\Popups\Modals\AbstractModal;
use Support\Client\Components\Popups\Notifications\AbstractNotificationComponent;
use Support\Enums\SessionKeyType;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class Response
{
    /**
     * @var Action
     */
    private Action $action;

    /**
     * @var string
     */
    private string $redirect;

    /**
     * @var array
     */
    private array $errors = [];

    /**
     * @var Component
     */
    private Component $component;

    /**
     * @var int
     */
    private int $statusCode = ResponseCode::HTTP_OK;

    /**
     * @var AbstractModal|AbstractPopupComponent
     */
    private AbstractPopupComponent|AbstractModal $popup;

    /**
     * @var array|JsonResource|ResourceCollection|string
     */
    private JsonResource|array|string|ResourceCollection $data;

    /**
     * @return Response
     */
    public static function create(): Response
    {
        return new static();
    }

    /**
     * @param Action $action
     *
     * @return Response
     */
    public function addAction(Action $action): Response
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
     * @param Component $component
     *
     * @return Response
     */
    public function addComponent(Component $component): Response
    {
        $this->component = $component;

        return $this;
    }

    /**
     * @param $statusCode
     *
     * @return Response
     */
    public function setStatusCode($statusCode): Response
    {
        $this->statusCode = $statusCode;

        if (isset($this->popup) && $this->popup instanceof AbstractNotificationComponent) {
            $this->popup->setAlertTypeByStatusCode($statusCode);
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
     * @param AbstractModal|AbstractPopupComponent $popup
     * @param int|null                             $statusCode
     *
     * @return Response
     */
    public function addPopup(AbstractPopupComponent|AbstractModal $popup, ?int $statusCode = null): Response
    {
        $this->popup = $popup;

        $this->setStatusCode($statusCode ?: $this->statusCode);

        return $this;
    }

    /**
     * @param array|string $key
     * @param array|null   $errors
     * @param int          $statusCode
     *
     * @return Response
     */
    public function addErrors(string|array $key, ?array $errors = null, int $statusCode = ResponseCode::HTTP_BAD_REQUEST): Response
    {
        $this->setStatusCode($statusCode);

        if (\is_null($errors)) {
            $this->errors = array_merge($this->errors, $key);
        } else {
            $this->errors[$key] = array_merge($this->errors[$key] ?? [], $errors);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function createResponseContent(): array
    {
        $response = [];

        if (! empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        if (isset($this->data)) {
            $response['data'] = $this->data;
        }

        if (isset($this->component)) {
            $response['component'] = $this->component->export();
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
     * @return HttpResponse|JsonResponse
     */
    public function toJson(): HttpResponse|JsonResponse
    {
        $content = $this->createResponseContent();

        return empty($content)
            ? ResponseConstructor::noContent()
            : ResponseConstructor::json($content, $this->statusCode);
    }

    /**
     * @param SessionKeyType $key
     *
     * @return Response
     */
    public function toSession(SessionKeyType $key = SessionKeyType::ONCE): Response
    {
        Session::put($key->value, $this->createResponseContent());

        return $this;
    }

    /**
     * @return Application|Redirector|RedirectResponse
     */
    public function toRedirect(): Redirector|Application|RedirectResponse
    {
        return Redirect::to($this->redirect);
    }

    /**
     * @param SessionKeyType $key
     *
     * @return mixed
     */
    public static function getSessionData(SessionKeyType $key = SessionKeyType::KEEP): mixed
    {
        return Session::get("{$key->value}.data");
    }
}
