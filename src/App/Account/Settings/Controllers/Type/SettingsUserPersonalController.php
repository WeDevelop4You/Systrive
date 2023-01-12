<?php

namespace App\Account\Settings\Controllers\Type;

use App\Account\Settings\Requests\UpdateUserProfileRequest;
use Domain\User\Actions\UpdateUserEmailAction;
use Domain\User\Actions\UpdateUserProfileAction;
use Domain\User\DataTransferObjects\UserProfileData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class SettingsUserPersonalController
{
    public function action(UpdateUserProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = new UserProfileData(...$request->validated());

        (new UpdateUserProfileAction($user))($data);
        (new UpdateUserEmailAction($user))($data->email);

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.success.saved'))
            )->toJson();
    }
}
