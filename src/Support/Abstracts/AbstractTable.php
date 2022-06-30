<?php

    namespace Support\Abstracts;

    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Data\Build\Column;

    abstract class AbstractTable
    {
        /**
         * @param mixed ...$arguments
         *
         * @return static
         */
        final public static function create(...$arguments): static
        {
            return new static(...$arguments);
        }

        final public function getHeaders(): array
        {
            return $this->getColumns()
                ->map(fn (Column $column) => $column->export())
                ->toArray();
        }

        final public function getFormattedColumnNames(): array
        {
            return $this->getColumns()
                ->filter(fn (Column $column) => $column->hasFormat)
                ->map(fn (Column $column) => $column->identifier)
                ->values()
                ->toArray();
        }

        /**
         * @return Collection
         */
        final public function getColumns(): Collection
        {
            return Collection::make($this->handle());
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
