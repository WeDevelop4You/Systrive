<?php

namespace Support\Graphql\Definitions\Types;

use GraphQL\Type\Definition\ObjectType;

abstract class ModelType extends Type
{
    /**
     * @return string
     */
    abstract protected function name(): string;

    /**
     * @return callable|array
     */
    abstract protected function fields(): callable|array;

    /**
     * @return callable|null
     */
    protected function isTypeOf(): callable|null
    {
        return null;
    }

    /**
     * @return callable|null
     */
    protected function resolve(): callable|null
    {
        return null;
    }

    /**
     * @return callable|array|null
     */
    protected function interfaces(): callable|array|null
    {
        return null;
    }

    final protected function toType(): ObjectType
    {
        return new ObjectType($this->options([
            'name' => $this->name(),
            'fields' => $this->fields(),
            'isTypeOf' => $this->isTypeOf(),
            'resolveField' => $this->resolve(),
            'interfaces' => $this->interfaces(),
        ]));
    }
}
