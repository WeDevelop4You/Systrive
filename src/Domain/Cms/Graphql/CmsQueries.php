<?php

namespace Domain\Cms\Graphql;

use Domain\Cms\Collections\CmsTableCollection;
use Support\Graphql\Definitions\Types\QueryType;

class CmsQueries extends QueryType
{
    /**
     * CmsQueries constructor
     *
     * @param CmsTableCollection $tables
     */
    protected function __construct(
        private readonly CmsTableCollection $tables
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): array
    {
        return $this->tables->createGraphqlQuery()->toArray();
    }
}
