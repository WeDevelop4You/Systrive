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
     * @param bool $condition
     *
     * @return $this
     */
    public function setMultiple(bool $condition = true): static
    {
        return $this->setAttribute('multiple', $condition);
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setChips(bool $condition = true): static
    {
        return $this->setAttribute('chips', $condition);
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setSmallChips(bool $condition = true): static
    {
        return $this->setAttribute('small-chips', $condition);
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setDeletableChips(bool $condition = true): static
    {
        return $this->setAttribute('deletable-chips', $condition);
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
