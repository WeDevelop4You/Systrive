<?php

namespace Support\Abstracts;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Support\Client\DataTable\Build\Column;

abstract class AbstractTable
{
    /**
     * @var Collection
     */
    private Collection $columns;

    /**
     * @param mixed ...$arguments
     *
     * @return static
     */
    final public static function create(...$arguments): static
    {
        return new static(...$arguments);
    }

    /**
     * @return Collection
     */
    final public function getColumns(): Collection
    {
        if (! isset($this->columns)) {
            $this->columns = Collection::make($this->handle());
        }

        return $this->columns;
    }

    /**
     * @param ...$permissions
     *
     * @return bool
     */
    final protected function can(...$permissions): bool
    {
        return Auth::user()->hasPermission(...$permissions);
    }

    /**
     * @return array|Column[]
     */
    abstract protected function handle(): array;
}
