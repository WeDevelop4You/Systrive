<?php

namespace App\Account\Authentication\Controllers;

use App\Account\Authentication\Requests\ResetPasswordRequest;
use App\Account\Authentication\Responses\ResetPasswordResponse;
use Domain\User\Actions\UpdateUserPasswordAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ResetPasswordController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return ResetPasswordResponse::create()->toJson();
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function action(ResetPasswordRequest $request): JsonResponse|RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmed', 'token'),
            function ($user, $password) {
                (new UpdateUserPasswordAction($user))($password);
            }
        );

        $response = Response::create();

        if ($status === Password::PASSWORD_RESET) {
            Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans($status)))
                ->toSession();

            $response->addRedirect(route('admin.login'));
        } else {
            $response->addPopup(SimpleNotificationComponent::create()->setText(trans($status)))
                ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }

        return $response->toJson();
    }
}
