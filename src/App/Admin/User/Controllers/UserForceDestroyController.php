<?php

namespace App\Admin\User\Controllers;

use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class UserForceDestroyController
{
    /**
     * @param User $user
     *
     * @return JsonResponse
     */
    public function action(User $user): JsonResponse
    {
        $user->forceDelete();

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.permanently.deleted')))
            ->toJson();
    }
}
