<?php

namespace Support\Graphql\Definitions\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\InputType as BaseInputType;

abstract class InputType extends Type implements BaseInputType
{
    /**
     * @return string
     */
    abstract protected function name(): string;

    /**
     * @return array|callable
     */
    abstract protected function fields(): array|callable;

    /**
     * @return callable|null
     */
    protected function parseValue(): callable|null
    {
        return null;
    }

    final protected function toType(): InputObjectType
    {
        return new InputObjectType($this->options([
            'name' => $this->name(),
            'fields' => $this->fields(),
            'parseValue' => $this->parseValue(),
        ]));
    }
}
