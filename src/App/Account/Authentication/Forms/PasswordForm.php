<?php

namespace App\Account\Authentication\Forms;

use Domain\User\Models\User;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\PasswordInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class PasswordForm extends AbstractForm
{
    protected function __construct(
        private readonly User $user
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setDisabled()
                            ->setKey('email')
                            ->setValue($this->user->email)
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
                        PasswordInputComponent::create()
                            ->setError()
                            ->setKey('password_confirm')
                            ->setLabel(trans('word.password.confirm'))
                    ),
            ]);
    }
}
