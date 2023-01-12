<?php

namespace App\Company\Company\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class CompanyForm extends AbstractForm
{
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
                            ->setKey('email')
                            ->setLabel(trans('word.email.email'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('domain')
                            ->setLabel(trans('word.domain.domain'))
                    ),
            ]);
    }
}
