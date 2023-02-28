<?php

namespace Domain\Cms\Graphql\Inputs\FilterTypes;

use Domain\Cms\Enums\CmsFilterType;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\InputType as BaseInputType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;
use Support\Graphql\Definitions\Entry;
use Support\Graphql\Definitions\Types\InputType;

abstract class CmsFilterTypeInput extends InputType
{
    /**
     * CmsFilterTypeInput constructor
     *
     * @param string|null $suffix
     */
    protected function __construct(
        private readonly string|null $suffix = null
    ) {
      //
    }

    /**
     * @return BaseInputType
     */
    abstract protected function type(): BaseInputType;

    /**
     * {@inheritDoc}
     */
    final protected function name(): string
    {
        $name = Str::of('FilterType');

        if (!is_null($this->suffix)) {
            $name = $name->append('For', ucfirst($this->suffix));
        }

        return $name->toString();
    }

    /**
     * @return callable|null
     */
    final protected function parseValue(): callable|null
    {
        return function (array $values) {
            if (count($values) > 1) {
                throw new Error('To many arguments');
            }

            return $values;
        };
    }

    /**
     * @return array
     */
    final protected function fieldEq(): array
    {
        return Entry::create(
            CmsFilterType::EQ->value,
            $this->type()
        );
    }

    /**
     * @return array
     */
    final protected function fieldNeq(): array
    {
        return Entry::create(
            CmsFilterType::NEQ->value,
            $this->type()
        );
    }

    /**
     * @return array
     */
    final protected function fieldLt(): array
    {
        return Entry::create(
            CmsFilterType::LT->value,
            $this->type(),
        );
    }

    /**
     * @return array
     */
    final protected function fieldLte(): array
    {
        return Entry::create(
            CmsFilterType::LTE->value,
            $this->type(),
        );
    }

    /**
     * @return array
     */
    final protected function fieldGt(): array
    {
        return Entry::create(
            CmsFilterType::GT->value,
            $this->type(),
        );
    }

    /**
     * @return array
     */
    final protected function fieldGte(): array
    {
        return Entry::create(
            CmsFilterType::GTE->value,
            $this->type(),
        );
    }

    /**
     * @return array
     */
    final protected function fieldLike(): array
    {
        return Entry::create(
            CmsFilterType::LIKE->value,
            Type::string()
        );
    }

    /**
     * @return array
     */
    final protected function fieldNotLike(): array
    {
        return Entry::create(
            CmsFilterType::NLIKE->value,
            Type::string()
        );
    }

    /**
     * @return array
     */
    final protected function fieldIsNull(): array
    {
        return Entry::create(
            CmsFilterType::IS_NULL->value,
            Type::boolean()
        );
    }

    /**
     * @return array
     */
    final protected function fieldIn(): array
    {
        return Entry::create(
            CmsFilterType::IN->value,
            Type::listOf($this->type())
        );
    }

    /**
     * @return array
     */
    final protected function fieldNin(): array
    {
        return Entry::create(
            CmsFilterType::NIN->value,
            Type::listOf($this->type())
        );
    }
}
