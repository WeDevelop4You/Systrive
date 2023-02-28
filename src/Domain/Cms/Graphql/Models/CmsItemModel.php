<?php

namespace Domain\Cms\Graphql\Models;

use Domain\Cms\Models\CmsTable;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Types\ModelType;

class CmsItemModel extends ModelType
{
    /**
     * ItemModel constructor
     *
     * @param string   $type
     * @param CmsTable $table
     */
    protected function __construct(
        private readonly CmsTable $table,
        private readonly string $type = ''
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return Str::of($this->table->name)
            ->append('Model', $this->type)
            ->studly()
            ->toString();
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): callable|array
    {
        return $this->table->columns->createGraphqlFields("{$this->table->name}{$this->type}")->toArray();
    }
}
