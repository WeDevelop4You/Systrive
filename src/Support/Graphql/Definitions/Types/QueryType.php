<?php

namespace Support\Graphql\Definitions\Types;

use GraphQL\Type\Definition\ObjectType;

abstract class QueryType extends Type
{
    /**
     * @return array
     */
    abstract protected function fields(): array;

    /**
     * {@inheritDoc}
     */
    final protected function toType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Query',
            'fields' => $this->fields(),
        ]);
    }
}
