<?php

    namespace App\Admin\Account\Controllers;

    use Domain\User\Actions\DeleteUserAccountSecurityAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class AccountDisableOneTimePasswordController
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
                        ->dispatch(
                            'user/auth/settings/page/component',
                            route('admin.account.settings.overview.page', 'security')
                        )
                )->toJson();
        }
    }
