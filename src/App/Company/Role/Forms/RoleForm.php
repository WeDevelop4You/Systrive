<?php

namespace App\Company\Role\Forms;

use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\Custom\CustomPermissionInputComponentType;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Enums\Component\Inputs\CustomPermissionInputType;

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
                        CustomPermissionInputComponentType::create()
                            ->setKey('permission')
                            ->setLabel(trans('word.permission'))
                            ->setType(CustomPermissionInputType::ROLE)
                    ),
            ]);
    }
}
