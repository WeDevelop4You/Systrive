<?php

namespace Support\Graphql\Definitions;

use GraphQL\Type\Definition\InputType;

class Entry
{
    /**
     * Field constructor
     *
     * @param string                     $name
     * @param Types\InputType            $type
     * @param string|float|bool|int|null $default
     */
    private function __construct(
        private readonly string $name,
        private readonly InputType $type,
        private readonly string|float|bool|int|null $default
    ) {
       //
    }

    /**
     * @param string                     $name
     * @param Types\InputType            $type
     * @param string|float|bool|int|null $default
     *
     * @return array
     */
    public static function create(
        string $name,
        InputType $type,
        string|float|bool|int|null $default = null
    ): array {
        $instants = new static($name, $type, $default);

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
            'defaultValue' => $this->default,
        ], fn ($value) => !is_null($value));
    }
}
