<?php

namespace App\Account\Authentication\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\OneTimePasswordInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class OneTimePasswordForm extends AbstractForm
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
                        OneTimePasswordInputComponent::create()
                            ->setKey('one_time_password')
                            ->setAction(VuexAction::create()->dispatch(
                                'guest/login/send',
                                route('account.login.otp')
                            ))
                    ),
            ]);
    }
}
