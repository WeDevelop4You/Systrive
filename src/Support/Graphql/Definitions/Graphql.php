<?php

namespace Support\Graphql\Definitions;

use GraphQL\Type\Definition\Type;

abstract class Graphql
{
    /**
     * @param ...$arguments
     *
     * @return array
     */
    public static function create(...$arguments): array
    {
        $instants = new static(...$arguments);

        return $instants->toArray();
    }

    /**
     * @return string
     */
    abstract protected function name(): string;

    /**
     * @return Type
     */
    abstract protected function type(): Type;

    /**
     * @return callable
     */
    abstract protected function resolve(): callable;

    /**
     * @return array|null
     */
    protected function args(): array|null
    {
        return null;
    }

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array_filter([
            'name' => $this->name(),
            'type' => $this->type(),
            'args' => $this->args(),
            'resolve' => $this->resolve(),
        ], fn ($value) => !is_null($value));
    }
}
