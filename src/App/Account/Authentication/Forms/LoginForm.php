<?php

namespace App\Account\Authentication\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\PasswordInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class LoginForm extends AbstractForm
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
                        TextInputComponent::create()
                            ->setError()
                            ->setAutofocus()
                            ->setKey('email')
                            ->setLabel(trans('word.email.email'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        PasswordInputComponent::create()
                            ->setError()
                            ->setKey('password')
                            ->setLabel(trans('word.password.password'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setClass('mt-0')
                            ->setKey('remember')
                            ->setLabel(trans('word.remember.me'))
                    ),
            ]);
    }
}
