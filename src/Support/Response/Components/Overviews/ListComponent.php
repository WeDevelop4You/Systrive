<?php

namespace Support\Response\Components\Overviews;

use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Items\AbstractItemComponent;

class ListComponent extends AbstractComponent
{
    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var bool
     */
    private bool $divider = false;

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
        return 'ListComponent';
    }

    /**
     * @param string $title
     *
     * @return ListComponent
     */
    public function addSubheader(string $title): ListComponent
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ListComponent
     */
    public function addDivider(): ListComponent
    {
        $this->divider = true;

        return $this;
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
                if ($item->getCondition()) {
                    $itemList[] = $item->export();
                }
            } else {
                $itemList[] = $item;
            }
        }

        if (empty($itemList)) {
            return $this;
        }

        if (!\is_null($this->title)) {
            $this->setData('list', ['subheader' => $this->title], true)
                ->setData('hasSubheader', true);

            $this->title = null;
        }

        if ($this->divider) {
            $this->setData('list', ['divider' => true], true);

            $this->divider = false;
        }

        return $this->setData(
            'list',
            ['items' => $itemList, 'columns' => round(12 / $columns),],
            true
        );
    }
}
