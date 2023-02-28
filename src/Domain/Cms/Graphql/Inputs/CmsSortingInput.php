<?php

namespace Domain\Cms\Graphql\Inputs;

use Domain\Cms\Collections\CmsColumnCollection;
use Support\Graphql\Definitions\Types\InputType;

class CmsSortingInput extends InputType
{
    /**
     * CmsSortingInput constructor
     *
     * @param CmsColumnCollection $columns
     */
    protected function __construct(
        private readonly CmsColumnCollection $columns
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return 'SortingColumns';
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): array|callable
    {
        return $this->columns->createGraphqlSorting()->toArray();
    }
}
