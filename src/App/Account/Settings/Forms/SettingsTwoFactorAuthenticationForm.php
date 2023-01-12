<?php

namespace App\Account\Settings\Forms;

use Ramsey\Uuid\UuidInterface;
use Support\Abstracts\AbstractForm;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\OneTimePasswordInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class SettingsTwoFactorAuthenticationForm extends AbstractForm
{
    public function __construct(
        private readonly UuidInterface $identifier
    ) {
        //
    }

    /**
     * @return FormComponent
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        OneTimePasswordInputComponent::create()
                            ->setKey('one_time_password')
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'settings/twoFactorAuthentication/send',
                                    route('account.settings.2fa.validate')
                                )->setCloseModalOnSuccessAction($this->identifier)
                            )
                    ),
            ]);
    }
}
