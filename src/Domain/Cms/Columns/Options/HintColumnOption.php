<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Definitions\ComponentOption;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Misc\HintComponent;

class HintColumnOption implements ComponentOption
{
    public function __construct(
        private readonly string $hint
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function getComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setClass(['pt-0', 'px-4'])
            ->setComponent(
                HintComponent::create()->setHint($this->hint)
            );
    }
}
