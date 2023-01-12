<?php

    namespace App\Account\Settings\Controllers\Type;

    use App\Account\Settings\Requests\ValidateOneTimePasswordRequest;
    use App\Account\Settings\Responses\SettingsTwoFactorAuthenticationResponse;
    use Domain\User\Actions\EnableUserAccountSecurityAction;
    use Illuminate\Http\JsonResponse;
    use Support\Client\Actions\VuexAction;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;

    class SettingsEnableTwoFactorAuthenticationController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return SettingsTwoFactorAuthenticationResponse::create()->toJson();
        }

        /**
         * @param ValidateOneTimePasswordRequest $request
         *
         * @return JsonResponse
         */
        public function action(ValidateOneTimePasswordRequest $request): JsonResponse
        {
            (new EnableUserAccountSecurityAction())();

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.2fa.enabled'))
                )->addAction(
                    VuexAction::create()->dispatch('settings/view', 'security')
                )->toJson();
        }
    }
