<?php

namespace Domain\Cms\Graphql\Inputs;

use Domain\Cms\Collections\CmsColumnCollection;
use Domain\Cms\Enums\CmsFilterType;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;
use Support\Graphql\Definitions\Entry;
use Support\Graphql\Definitions\Types\InputType;

class CmsFilterInput extends InputType
{
    /**
     * CmsFilterInput constructor
     *
     * @param CmsColumnCollection $columns
     */
    protected function __construct(
        private readonly CmsColumnCollection $columns
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        return 'FilterColumns';
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): array|callable
    {
        $filters = $this->columns->createGraphqlFilter()->toArray();

        return [
            ...$filters,
            Entry::create(
                CmsFilterType::AND->value,
                Type::listOf(new InputObjectType([
                    'name' => 'FilterAnd',
                    'fields' => $filters,
                    'parseValue' => fn (array $values) => count($values) > 1 ? $this->createFilterArray($values) : $values,
                ])),
            ),
            Entry::create(
                CmsFilterType::OR->value,
                Type::listOf(new InputObjectType([
                    'name' => 'FilterOr',
                    'fields' => $filters,
                    'parseValue' => fn (array $values) => count($values) > 1 ? $this->createFilterArray($values) : $values,
                ])),
            ),
        ];
    }

    protected function parseValue(): callable|null
    {
        return function (array $values) {
            $keys = array_keys($values);
            $booleans = CmsFilterType::booleans();

            if (count(array_intersect($keys, $booleans)) > 0) {
                if (count(array_diff($keys, $booleans)) > 0) {
                    $options = implode("' or '", $booleans);

                    throw new Error("Use only the column names or '{$options}'");
                }

                return Arr::map($values, function (array $filers) {
                    $first = Arr::first($filers);

                    return count($first) > 1 ? $first : $filers;
                });
            }

            return [CmsFilterType::AND->value => $this->createFilterArray($values)];
        };
    }

    /**
     * @param array $values
     *
     * @return array
     */
    private function createFilterArray(array $values): array
    {
        $filters = [];

        foreach ($values as $column => $type) {
            $filters[] = [$column => $type];
        }

        return $filters;
    }
}
