<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Actions\Action;
use Support\Client\Components\Forms\Attributes\InputComponentWithDropdown;

class SelectInputComponent extends AbstractInputComponent
{
    use InputComponentWithDropdown;

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'SelectInputComponent';
    }

    /**
     * @param Action $action
     *
     * @return static
     */
    public function setChangeAction(Action $action): static
    {
        return $this->setData('changeAction', $action->export());
    }
}
