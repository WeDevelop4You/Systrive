<?php

namespace App\Admin\Supervisor\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CodeEditorInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;

class SupervisorProcessForm extends AbstractForm
{
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('name')
                            ->setLabel(trans('word.name.name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CodeEditorInputComponent::create()
                            ->setKey('config')
                            ->setLabel(trans('word.config.config'))
                    ),
            ]);
    }
}
