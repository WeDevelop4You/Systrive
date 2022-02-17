<?php

    namespace App\Admin\User\Account\Controllers;

    use Domain\User\Actions\UserAccountDisable2FAAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class UserAccountDisable2FAController
    {
        /**
         * @return JsonResponse
         */
        public function action(): JsonResponse
        {
            (new UserAccountDisable2FAAction())(Auth::user());

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.2fa.disabled')))
                ->toJson();
        }
    }
