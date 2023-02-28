<?php

namespace Domain\Cms\Graphql\Mutations;

use Domain\Cms\Graphql\Models\CmsItemModel;
use Domain\Cms\Models\CmsTable;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Entry;
use Support\Graphql\Definitions\Mutation;
use Support\Services\Cms;

class CmsUpdateMutation extends Mutation
{
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
     * @param ...$arguments
     *
     * @return array
     */
    public static function create(...$arguments): array
    {
        $instants = new static(...$arguments);

        return $instants->table->columns->whereUpdatable()->isNotEmpty()
            ? $instants->toArray()
            : [];
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return Str::of('update')->append(
            Str::ucfirst($this->table->query)
        )->camel();
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): Type
    {
        return Type::nonNull(CmsItemModel::create($this->table, 'Update'));
    }

    /**
     * @return array|null
     */
    protected function args(): array|null
    {
        return [
            Entry::create(
                'id',
                Type::nonNull(Type::id())
            ),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function resolve(): callable
    {
        return function ($root, array $args) {
            Cms::setTable($this->table);
        };
    }
}
