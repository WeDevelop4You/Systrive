<?php

    namespace App\Admin\Account\Controllers;

    use App\Admin\Account\Requests\ValidateOneTimePasswordRequest;
    use Domain\User\Actions\GenerateSecurityKeyAction;
    use Domain\User\Actions\UserAccountEnableSecurityAction;
    use Illuminate\Http\JsonResponse;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use function trans;

    class AccountEnable2FAController
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
            $data = (new GenerateSecurityKeyAction())();

            return Response::create()
                ->addData($data)
                ->toJson();
        }

        /**
         * @param ValidateOneTimePasswordRequest $request
         *
         * @return JsonResponse
         */
        public function action(ValidateOneTimePasswordRequest $request): JsonResponse
        {
            $oneTimePassword = $request->get('one_time_password');

            (new UserAccountEnableSecurityAction())($oneTimePassword);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.2fa.enabled')))
                ->toJson();
        }
    }
