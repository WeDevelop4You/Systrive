<?php

namespace Support\Graphql\Definitions\Types;

use GraphQL\Type\Definition\ObjectType;

abstract class MutationType extends Type
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
            'name' => 'Mutation',
            'fields' => $this->fields(),
        ]);
    }
}
