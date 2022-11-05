<?php

namespace App\Admin\Supervisor\Forms;

use Support\Abstracts\AbstractForm;
use Support\Response\Components\Forms\AbstractFormComponent;
use Support\Response\Components\Forms\FormComponent;
use Support\Response\Components\Forms\Inputs\CodeEditorInputComponent;
use Support\Response\Components\Forms\Inputs\TextInputComponent;
use Support\Response\Components\Forms\Utils\InputColWrapper;

class SupervisorProcessForm extends AbstractForm
{
    protected function handle(): AbstractFormComponent
    {
        return FormComponent::create()
            ->setInputs([
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
