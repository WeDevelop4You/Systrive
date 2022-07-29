<?php

namespace Support\Helpers\DataTable\Build;

use Illuminate\Database\Eloquent\Collection;

class Paginator
{
    public function __construct(
        private readonly int $total,
        private readonly Collection $items
    ) {
        //
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * @return Collection
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
