<?php

namespace App\Account\Authentication\Controllers;

use App\Account\Authentication\Requests\LoginRequest;
use App\Account\Authentication\Responses\LoginResponse;
use App\Account\Authentication\Responses\OneTimePasswordResponse;
use Domain\Authentication\Exceptions\RequiresSecurityException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Helpers\ApplicationHelper;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class LoginController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return LoginResponse::create()->toJson();
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function action(LoginRequest $request): JsonResponse
    {
        $response = Response::create();

        try {
            $request->authenticate();

            Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.login')))
                ->toSession();

            $response->addRedirect(ApplicationHelper::getRedirectRoute());
        } catch (ValidationException $e) {
            $response->addErrors($e->errors());
        } catch (RequiresSecurityException) {
            $response = OneTimePasswordResponse::create()
                ->setStatusCode(ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $response->toJson();
    }
}
