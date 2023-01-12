<?php

namespace App\Account\Authentication\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class RecoveryForm extends AbstractForm
{
    /**
     * @inheritDoc
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->addItem(
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setAutofocus()
                            ->setKey('email')
                            ->setLabel(trans('word.email.email'))
                    )
            );
    }
}
