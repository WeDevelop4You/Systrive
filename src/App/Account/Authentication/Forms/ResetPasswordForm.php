<?php

namespace App\Account\Authentication\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\PasswordInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class ResetPasswordForm extends AbstractForm
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
                            ->setError()
                            ->setKey('password')
                            ->setLabel(trans('word.password.password'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        PasswordInputComponent::create()
                            ->setError()
                            ->setKey('password_confirm')
                            ->setLabel(trans('word.password.confirm'))
                    ),
            ]);
    }
}
