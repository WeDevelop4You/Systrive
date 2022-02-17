<?php

    namespace App\Admin\User\Account\Controllers;

    use App\Admin\Authentication\Requests\OneTimePasswordRequest;
    use Domain\User\Actions\Generate2FAKeyAction;
    use Domain\User\Actions\UserAccountDisable2FAAction;
    use Domain\User\Actions\UserAccountEnable2FAAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
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
