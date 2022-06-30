<?php

    namespace App\Admin\Account\Controllers;

    use App\Admin\Account\Requests\ValidateOneTimePasswordRequest;
    use Domain\User\Actions\EnableUserAccountSecurityAction;
    use Domain\User\Actions\GenerateSecurityKeyAction;
    use Illuminate\Http\JsonResponse;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
    use Support\Enums\FormTypes;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Forms\CustomFormComponent;
    use Support\Response\Components\Popups\Modals\FormModal;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use function trans;

    class AccountEnableOneTimePasswordController
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
                ->addData(['QRCode' => $data])
                ->addPopup(
                    FormModal::create('user/auth/settings/oneTimePassword')
                        ->setPersistent()
                        ->setWidth(400)
                        ->setTitle(trans('word.otp.enable'))
                        ->setForm(
                            CustomFormComponent::create()
                                ->setType(FormTypes::ONE_TIME_PASSWORD_ENABLE),
                            'pa-0'
                        )
                )
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

            (new EnableUserAccountSecurityAction())($oneTimePassword);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.success.2fa.enabled'))
                )->addAction(
                    VuexAction::create()
                        ->dispatch(
                            'user/auth/settings/page/component',
                            route('admin.account.settings.overview.page', 'security')
                        )
                )->toJson();
        }
    }
