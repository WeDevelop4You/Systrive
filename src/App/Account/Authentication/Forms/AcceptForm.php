<?php

namespace App\Account\Authentication\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Misc\ContentComponent;

class AcceptForm extends AbstractForm
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                ColComponent::create()
                    ->setComponent(
                        ContentComponent::create()
                            ->setClass('mb-0')
                            ->setValue(trans('text.complete.registration'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setKey('accept')
                            ->setClass(['mt-0', 'pl-2'])
                            ->setLabel(trans('word.terms_and_conditions'))
                    ),
            ]);
    }
}
