<?php

namespace Support\Response\Components\Forms\InputTypes;

use Support\Response\Actions\AbstractAction;
use Support\Response\Components\Forms\Helpers\SelectInputValueHelper;

class SelectInputComponent extends AbstractInputComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'SelectInput';
    }

    /**
     * @param array $items
     *
     * @return SelectInputComponent
     */
    public function setItems(array $items): SelectInputComponent
    {
        if (array_is_list($items)) {
            return $this->setData('items', $items);
        }

        foreach ($items as $item) {
            if ($item instanceof SelectInputValueHelper) {
                $this->addItem($item);
            }
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
        if ($item instanceof SelectInputValueHelper) {
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
