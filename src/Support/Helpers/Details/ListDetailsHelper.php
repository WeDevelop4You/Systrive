<?php

namespace Support\Helpers\Details;

use Support\Abstracts\AbstractListItem;

class ListDetailsHelper
{
    private array $items = [];

    /**
     * @return ListDetailsHelper
     */
    public static function create(): ListDetailsHelper
    {
        return new static();
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function addSubheader(string $title): ListDetailsHelper
    {
        $this->items[] = ['subheader' => $title];

        return $this;
    }

    public function addDivider(): ListDetailsHelper
    {
        $this->items[] = ['divider' => true];

        return $this;
    }

    /**
     * @param array $items
     * @param int   $columns
     *
     * @return $this
     */
    public function addDetails(array $items, int $columns = 1): ListDetailsHelper
    {
        $details = [];

        foreach ($items as $item) {
            if ($item instanceof AbstractListItem) {
                $details[] = $item->export();
            } else {
                $details[] = $item;
            }
        }

        $this->items[] = [
            'columns' => round(12 / $columns),
            'details' => $details,
        ];

        return $this;
    }

    public function export(): array
    {
        return $this->items;
    }
}
