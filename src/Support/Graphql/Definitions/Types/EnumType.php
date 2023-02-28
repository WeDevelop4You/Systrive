<?php

namespace Support\Graphql\Definitions\Types;

use GraphQL\Type\Definition\EnumType as BaseEnumType;
use GraphQL\Type\Definition\InputType;
use GraphQL\Type\Definition\OutputType;

abstract class EnumType extends Type implements InputType, OutputType
{
    /**
     * @return string
     */
    abstract protected function name(): string;

    /**
     * @return array
     */
    abstract protected function values(): array;

    final protected function toType(): BaseEnumType
    {
        return new BaseEnumType($this->options([
            'name' => $this->name(),
            'values' => $this->values(),
        ]));
    }
}
