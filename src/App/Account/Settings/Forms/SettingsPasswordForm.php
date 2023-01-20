<?php

namespace App\Account\Settings\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\PasswordInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Misc\CustomComponent;

class SettingsPasswordForm extends AbstractForm
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        PasswordInputComponent::create()
                            ->setKey('current_password')
                            ->setLabel(trans('word.password.current'))
                    ),
                ColComponent::create()->setComponent(
                    CustomComponent::create()
                        ->setType('PasswordRequirementsComponent')
                        ->setData('vuexNamespace', 'settings/password/password')
                ),
                InputColWrapper::create()
                    ->setInput(
                        PasswordInputComponent::create()
                            ->setKey('password')
                            ->setLabel(trans('word.password.new'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        PasswordInputComponent::create()
                            ->setKey('password_confirm')
                            ->setLabel(trans('word.password.confirm'))
                    ),
            ]);
    }
}
