<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Actions\AbstractAction;
use Support\Response\Components\Forms\Utils\KeyValueObject;

class SelectInputComponent extends AbstractInputComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'SelectInputComponent';
    }

    /**
     * @return SelectInputComponent
     */
    public function setReturnObject(): SelectInputComponent
    {
        return $this->setAttribute('return-object', true);
    }

    /**
     * @param array $items
     *
     * @return SelectInputComponent
     */
    public function setItems(array $items): SelectInputComponent
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @param mixed $item
     *
     * @return SelectInputComponent
     */
    public function addItem(mixed $item): SelectInputComponent
    {
        if ($item instanceof KeyValueObject) {
            $item = $item->export();
        }

        return $this->setData('items', $item, true);
    }

    /**
     * @param AbstractAction $action
     *
     * @return SelectInputComponent
     */
    public function setChangeAction(AbstractAction $action): SelectInputComponent
    {
        return $this->setData('changeAction', $action->export());
    }
}
