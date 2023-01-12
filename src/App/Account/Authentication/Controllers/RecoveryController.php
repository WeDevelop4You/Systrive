<?php

namespace App\Account\Authentication\Controllers;

use App\Account\Authentication\Requests\PasswordRecoveryRequest;
use App\Account\Authentication\Responses\RecoveryResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class RecoveryController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return RecoveryResponse::create()->toJson();
    }

    /**
     * @param PasswordRecoveryRequest $request
     *
     * @return JsonResponse
     */
    public function action(PasswordRecoveryRequest $request): JsonResponse
    {
        $response = Response::create();
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            $response->addPopup(SimpleNotificationComponent::create()->setText(trans($status)));
        } else {
            $response->addErrors('email', [trans($status)]);
        }

        return $response->toJson();
    }
}
