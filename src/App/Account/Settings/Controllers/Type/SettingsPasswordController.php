<?php

    namespace App\Account\Settings\Controllers\Type;

    use App\Account\Settings\Requests\ChangePasswordRequest;
    use Domain\User\Actions\UpdateUserPasswordAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;

    class SettingsPasswordController
    {
        /**
         * @param ChangePasswordRequest $request
         *
         * @return JsonResponse
         */
        public function action(ChangePasswordRequest $request): JsonResponse
        {
            $password = $request->get('password');

            (new UpdateUserPasswordAction(Auth::user()))($password);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
