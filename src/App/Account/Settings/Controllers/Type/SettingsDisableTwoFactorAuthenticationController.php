<?php

    namespace App\Account\Settings\Controllers\Type;

    use Domain\User\Actions\DeleteUserAccountSecurityAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Client\Actions\VuexAction;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;

    class SettingsDisableTwoFactorAuthenticationController
    {
        /**
         * @return JsonResponse
         */
        public function action(): JsonResponse
        {
            (new DeleteUserAccountSecurityAction())(Auth::user());

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(
                            trans('response.success.2fa.disabled')
                        )
                )->addAction(
                    VuexAction::create()
                        ->dispatch('settings/view', 'security')
                )->toJson();
        }
    }
