<?php

    namespace Support\Abstracts;

    use Domain\Role\Mappings\RoleTableMap;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Data\Build\Column;

    abstract class AbstractTable
    {
        /**
         * @var array|Column[]
         */
        protected array $structure = [];

        /**
         * @return static
         */
        final public static function create(): static
        {
            $instance = new static();
            $instance->structure();

            return $instance;
        }

        final public function getHeaders(): array
        {
            return $this->getColumns()->map(function (Column $column) {
                return [
                    'text' => $column->text,
                    'value' => $column->identifier,
                    'divider' => $column->hasDivider,
                    'sortable' => $column->isSortable,
                    'align' => $column->alignment->value,
                    'filterable' => $column->isSearchable,
                ];
            })->toArray();
        }

        /**
         * @return Collection
         */
        final public function getColumns(): Collection
        {
            return Collection::make($this->structure);
        }

        /**
         * @param ...$permissions
         *
         * @return bool
         */
        final protected function can(...$permissions): bool
        {
            $user = Auth::user();

            if ($user->hasRole(RoleTableMap::SUPER_ADMIN_ROLE)) {
                return true;
            }

            return $user->hasAnyPermission($permissions);
        }

        /**
         * @return void
         */
        abstract protected function structure(): void;
    }
