<?php

namespace App\Account\Settings\Responses;

use App\Account\Settings\Forms\SettingsTwoFactorAuthenticationForm;
use Domain\User\Actions\GenerateSecurityKeyAction;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use Ramsey\Uuid\UuidInterface;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\ContentComponent;
use Support\Client\Components\Misc\ImageComponent;
use Support\Client\Components\Overviews\Steppers\StepperItemComponent;
use Support\Client\Components\Overviews\Steppers\VerticalStepperComponent;
use Support\Client\Components\Popups\Modals\DialogComponent;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class SettingsTwoFactorAuthenticationResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $dialog = DialogComponent::create();

        try {
            return Response::create()
                ->addPopup(
                    $dialog->setPersistent()
                        ->setWidth(400)
                        ->setModal(
                            VerticalStepperComponent::create()
                                ->setVuexNamespace('settings/twoFactorAuthentication/stepper')
                                ->setHeader(
                                    CardHeaderComponent::create()
                                        ->setClass('pt-2')
                                        ->setTitle(trans('word.2fa.enable'))
                                        ->setCloseButton(
                                            VuexAction::create()->closeModal($dialog->getIdentifier())
                                        )
                                )
                                ->setItems([
                                    $this->createQrCode($dialog->getIdentifier()),
                                    $this->createVerify($dialog->getIdentifier()),
                                ])
                        )
                        ->setCloseAction(ChainAction::create()->setActions([
                            VuexAction::create()->commit(
                                'settings/twoFactorAuthentication/form/resetForm'
                            ),
                            VuexAction::create()->commit(
                                'settings/twoFactorAuthentication/stepper/reset'
                            ),
                        ]))
                );
        } catch (IncompatibleWithGoogleAuthenticatorException|InvalidCharactersException|InvalidAlgorithmException|SecretKeyTooShortException) {
            return Response::create()->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.something.wrong')),
                ResponseCode::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @param UuidInterface $identifier
     *
     * @return StepperItemComponent
     *
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidAlgorithmException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    private function createQrCode(UuidInterface $identifier): StepperItemComponent
    {
        return StepperItemComponent::create()
            ->setTitle(trans('word.scan.qr.code'))
            ->setComponents([
                ContentComponent::create()
                    ->setClass('mb-0')
                    ->setValue(trans('text.how.to.enable.2fa')),
                ImageComponent::create()
                    ->setSize(200)
                    ->setMinHeight(200)
                    ->setClass('mx-auto')
                    ->setAlt('2fa-qr-code')
                    ->setSource((new GenerateSecurityKeyAction())()),
                MultipleButtonComponent::create()
                    ->setClass('gap-3')
                    ->setButtons([
                        ButtonComponent::create()
                            ->setType()
                            ->setTitle(trans('word.cancel.cancel'))
                            ->setAction(VuexAction::create()->closeModal($identifier)),
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.next.next'))
                            ->setAction(VuexAction::create()->commit(
                                'settings/twoFactorAuthentication/stepper/next'
                            )),
                    ]),
            ]);
    }

    private function createVerify(UuidInterface $identifier): StepperItemComponent
    {
        return StepperItemComponent::create()
            ->setTitle(trans('word.scan.verify.2fa'))
            ->setComponents([
                ContentComponent::create()
                    ->setClass('mb-0')
                    ->setValue(trans('text.verify.2fa')),
                SettingsTwoFactorAuthenticationForm::create($identifier)
                    ->setVuexNamespace('settings/twoFactorAuthentication/form'),
                MultipleButtonComponent::create()
                    ->setClass('gap-3')
                    ->setButtons([
                        ButtonComponent::create()
                            ->setType()
                            ->setTitle(trans('word.back.back'))
                            ->setAction(VuexAction::create()->commit(
                                'settings/twoFactorAuthentication/stepper/back'
                            )),
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.verify.verify'))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'settings/twoFactorAuthentication/send',
                                    route('account.settings.2fa.validate')
                                )->setCloseModalOnSuccessAction($identifier)
                            ),
                    ]),
            ]);
    }
}
