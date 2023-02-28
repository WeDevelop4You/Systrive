<?php

namespace Support\Graphql\Definitions;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;

class Field
{
    /**
     * ObjectType constructor
     *
     * @param                                          $resolve
     * @param string                                   $name
     * @param array|null                               $args
     * @param ObjectType|NonNull|ListOfType|ScalarType $type
     */
    private function __construct(
        private $resolve,
        private readonly string $name,
        private readonly array|null $args,
        private readonly ObjectType|NonNull|ListOfType|ScalarType $type,
    ) {
        //
    }

    /**
     * @param string                                   $name
     * @param ObjectType|NonNull|ListOfType|ScalarType $type
     * @param array|null                               $args
     * @param callable|null                            $resolve
     *
     * @return array
     */
    public static function create(
        string $name,
        ObjectType|NonNull|ListOfType|ScalarType $type,
        array|null $args = null,
        callable|null $resolve = null
    ): array {
        $instants = new static($resolve, $name, $args, $type);

        return $instants->toArray();
    }

    /**
     * @return array
     */
    private function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'type' => $this->type,
            'args' => $this->args,
            'resolve' => $this->resolve,
        ], fn ($value) => !is_null($value));
    }
}
