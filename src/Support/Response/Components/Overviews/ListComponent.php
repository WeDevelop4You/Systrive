<?php

namespace Support\Response\Components\Overviews;

use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Items\AbstractItemComponent;

class ListComponent extends AbstractComponent
{
    protected function __construct()
    {
        parent::__construct();

        $this->setData('hasSubheader', false);
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'List';
    }

    /**
     * @param string $title
     *
     * @return ListComponent
     */
    public function addSubheader(string $title): ListComponent
    {
        return $this->setData('list', ['subheader' => $title], true)
            ->setData('hasSubheader', true);
    }

    /**
     * @return ListComponent
     */
    public function addDivider(): ListComponent
    {
        return $this->setData('list', ['divider' => true], true);
    }

    /**
     * @param array $items
     * @param int   $columns
     *
     * @return ListComponent
     */
    public function addItems(array $items, int $columns = 1): ListComponent
    {
        $itemList = [];

        foreach ($items as $item) {
            if ($item instanceof AbstractItemComponent) {
                $itemList[] = $item->export();
            } else {
                $itemList[] = $item;
            }
        }

        return $this->setData('list', [
            'items' => $itemList,
            'columns' => round(12 / $columns),
        ], true);
    }
}
