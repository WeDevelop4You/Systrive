<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Attributes\ComponentOption;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Misc\LabelComponent;

class LabelColumnOption implements ComponentOption
{
    public function __construct(
        private readonly string $label
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    public function getComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setClass('pb-0')
            ->setComponent(
                LabelComponent::create()->setLabel($this->label)
            );
    }
}