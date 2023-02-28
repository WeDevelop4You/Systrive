<?php

namespace Domain\Cms\Graphql\Mutations;

use Domain\Cms\Graphql\Models\CmsItemModel;
use Domain\Cms\Models\CmsTable;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Mutation;
use Support\Services\Cms;

class CmsCreateMutation extends Mutation
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

    public static function create(...$arguments): array
    {
        $instants = new static(...$arguments);

        if ($instants->table->is_table) {
            return $instants->table->columns->whereCreatable()->isNotEmpty()
                ? $instants->toArray()
                : [];
        }

        return [];
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return Str::of('create')->append(
            Str::ucfirst($this->table->query)
        )->camel();
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): Type
    {
        return Type::nonNull(CmsItemModel::create($this->table, 'Create'));
    }

    /**
     * @return array|null
     */
    protected function args(): array|null
    {
        return [

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
