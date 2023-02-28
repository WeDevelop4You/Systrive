<?php

namespace Domain\Cms\Graphql\Mutations;

use Domain\Cms\Graphql\Models\CmsItemModel;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Entry;
use Support\Graphql\Definitions\Mutation;
use Support\Services\Cms;

class CmsDeleteMutation extends Mutation
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
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return Str::of('delete')->append(
            Str::ucfirst($this->table->query)
        )->camel();
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): Type
    {
        return Type::nonNull(CmsItemModel::create($this->table, 'Delete'));
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
            )
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function resolve(): callable
    {
        return function ($root, array $args) {
            Cms::setTable($this->table);

            $item = CmsModel::find($args['id']);

            if ($item instanceof CmsModel) {
                $item->delete();

                return $item;
            }

            throw new Error('Item not found');
        };
    }
}
