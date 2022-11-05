<?php

namespace Domain\Cms\Columns\Options\Nullable;

use Illuminate\Foundation\Http\FormRequest;
use Support\Response\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Response\Components\Layouts\ColComponent;

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
