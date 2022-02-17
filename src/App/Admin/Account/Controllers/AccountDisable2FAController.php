<?php

    namespace App\Admin\Account\Controllers;

    use Domain\User\Actions\UserAccountDeleteSecurityAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use function trans;

    class AccountDisable2FAController
    {
        /**
         * @return JsonResponse
         */
        public function action(): JsonResponse
        {
            (new UserAccountDeleteSecurityAction())(Auth::user());

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.2fa.disabled')))
                ->toJson();
        }
    }
