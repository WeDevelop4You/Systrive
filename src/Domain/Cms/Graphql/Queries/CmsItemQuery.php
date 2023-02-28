<?php

namespace Domain\Cms\Graphql\Queries;

use Domain\Cms\Enums\CmsFilterType;
use Domain\Cms\Graphql\Inputs\CmsFilterInput;
use Domain\Cms\Graphql\Inputs\CmsSortingInput;
use Domain\Cms\Graphql\Models\CmsItemModel;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Entry;
use Support\Graphql\Definitions\Query;
use Support\Services\Cms;

class CmsItemQuery extends Query
{
    private const FILTER = 'filter';
    private const SORTING = 'sorting';

    /**
     * CmsItemQuery constructor
     *
     * @param CmsTable $table
     */
    protected function __construct(
        private readonly CmsTable $table,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return Str::camel($this->table->query);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): Type
    {
        $model = Type::nonNull(CmsItemModel::create($this->table));

        return $this->isTable() ? Type::listOf($model) : $model;
    }

    /**
     * @return array|null
     */
    protected function args(): array|null
    {
        if ($this->isTable()) {
            return [
                Entry::create(
                    self::FILTER,
                    CmsFilterInput::create($this->table->columns),
                ),
                Entry::create(
                    self::SORTING,
                    CmsSortingInput::create($this->table->columns),
                ),
            ];
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    protected function resolve(): callable
    {
        return function ($root, array $args) {
            Cms::setTable($this->table);

            $query = CmsModel::query();

            if ($this->isTable()) {
                if (Arr::has($args, self::FILTER)) {
                    $filter = Arr::get($args, self::FILTER, []);

                    $this->filter($query, Arr::get($filter, CmsFilterType::AND->value, []), 'and');
                    $this->filter($query, Arr::get($filter, CmsFilterType::OR->value, []), 'or');
                }

                if (Arr::has($args, self::SORTING)) {
                    $sorting = Arr::get($args, self::SORTING, []);

                    foreach ($sorting as $column => $direction) {
                        $query->orderBy($column, $direction);
                    }
                }

                return $query->get();
            }

            return $query->latest()->first();
        };
    }

    /**
     * @return bool
     */
    private function isTable(): bool
    {
        return $this->table->is_table;
    }

    /**
     * @param Builder $query
     * @param array   $filters
     * @param string  $boolean
     *
     * @return void
     *
     * @throws Error
     */
    private function filter(Builder $query, array $filters, string $boolean): void
    {
        foreach ($filters as $filter) {
            $column = key($filter);
            $type = Arr::first($filter);

            CmsFilterType::from(key($type))->query($query, $column, Arr::first($type), $boolean);
        }
    }
}
