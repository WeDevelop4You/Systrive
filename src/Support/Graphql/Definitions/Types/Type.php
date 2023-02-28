<?php

namespace Support\Graphql\Definitions\Types;

use GraphQL\Type\Definition\Type as BaseType;

abstract class Type
{
    /**
     * @param ...$arguments
     *
     * @return BaseType
     */
    final public static function create(...$arguments): BaseType
    {
        $instants = new static(...$arguments);

        return $instants->toType();
    }

    /**
     * @param array $values
     *
     * @return array
     */
    final protected function options(array $values): array
    {
        return array_filter($values, fn ($value) => !is_null($value));
    }

    /**
     * @return BaseType
     */
    abstract protected function toType(): BaseType;
}
