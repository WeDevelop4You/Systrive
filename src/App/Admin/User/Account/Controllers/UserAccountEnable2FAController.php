<?php

    namespace App\Admin\User\Account\Controllers;

    use App\Admin\Authentication\Requests\OneTimePasswordRequest;
    use Domain\User\Actions\Generate2FAKeyAction;
    use Domain\User\Actions\UserAccountEnable2FAAction;
    use Illuminate\Http\JsonResponse;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class UserAccountEnable2FAController
    {
        /**
         * @throws IncompatibleWithGoogleAuthenticatorException
         * @throws InvalidAlgorithmException
         * @throws InvalidCharactersException
         * @throws SecretKeyTooShortException
         *
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $data = (new Generate2FAKeyAction())();

            return Response::create()
                ->addData($data)
                ->toJson();
        }

        /**
         * @param OneTimePasswordRequest $request
         *
         * @return JsonResponse
         */
        public function action(OneTimePasswordRequest $request): JsonResponse
        {
            $oneTimePassword = $request->get('one_time_password');

            (new UserAccountEnable2FAAction())($oneTimePassword);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.2fa.enabled')))
                ->toJson();
        }
    }
