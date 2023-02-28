<?php

namespace App\Company\Cms\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class CmsApiForm extends AbstractForm
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()->setInput(
                    TextInputComponent::create()
                        ->setKey('key')
                        ->setLabel(trans('word.api.key'))
                        ->setAppendOuter()
                ),
                InputColWrapper::create()->setInput(
                    TextInputComponent::create()
                        ->setKey('domains')
                        ->setLabel(trans('word.domains'))
                ),
            ]);
    }
}
