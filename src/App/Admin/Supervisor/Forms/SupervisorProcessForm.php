<?php

namespace App\Admin\Supervisor\Forms;

use Support\Abstracts\AbstractForm;
use Support\Response\Components\Forms\AbstractFormComponent;
use Support\Response\Components\Forms\FormComponent;
use Support\Response\Components\Forms\Helpers\ColWithInputHelper;
use Support\Response\Components\Forms\InputTypes\CodeEditorInputComponent;
use Support\Response\Components\Forms\InputTypes\TextInputComponent;

class SupervisorProcessForm extends AbstractForm
{
    protected function handle(): AbstractFormComponent
    {
        return FormComponent::create()
            ->setInputs([
                ColWithInputHelper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('name')
                            ->setLabel(trans('word.name.name'))
                    ),
                ColWithInputHelper::create()
                    ->setInput(
                        CodeEditorInputComponent::create()
                            ->setKey('config')
                            ->setLabel(trans('word.config.config'))
                    ),
            ]);
    }
}
