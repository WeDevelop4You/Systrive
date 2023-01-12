<?php

namespace Domain\Cms\Columns\Options\Nullable;

use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class NullableColumnOption extends AbstractNullableColumnOption
{
    /**
     * @param bool $isEditing
     *
     * @inheritDoc
     */
    public function getFormComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setMdCol(6)
            ->setComponent(
                CheckboxInputComponent::create()
                    ->setKey($this->getFormKey())
                    ->setLabel(trans('word.nullable'))
                    ->setVuexNamespace($this->getVuexNameSpace())
            );
    }
}
