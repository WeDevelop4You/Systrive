<?php

namespace App\Company\Role\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\Custom\CustomPermissionInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Enums\Component\Form\FormPermissionInputType;

class RoleForm extends AbstractForm
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
                            ->setKey('name')
                            ->setLabel(trans('word.name.name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CustomPermissionInputComponent::create()
                            ->setKey('permission')
                            ->setLabel(trans('word.permission'))
                            ->setType(FormPermissionInputType::ROLE)
                    ),
            ]);
    }
}
