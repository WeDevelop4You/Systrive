<?php

namespace Domain\Cms\Columns\Options\Nullable;

use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;

class NullableColumnOption extends AbstractNullableColumnOption
{
    protected function col(): int
    {
        return 6;
    }

    /**
     * @param bool $isEditing
     *
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return CheckboxInputComponent::create()->setLabel(trans('word.nullable'));
    }
}
