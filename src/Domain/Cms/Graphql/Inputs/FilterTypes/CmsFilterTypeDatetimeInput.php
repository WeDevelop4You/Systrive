<?php

namespace Domain\Cms\Graphql\Inputs\FilterTypes;

use GraphQL\Type\Definition\InputType as BaseInputType;
use GraphQL\Type\Definition\Type;

class CmsFilterTypeDatetimeInput extends CmsFilterTypeInput
{
    protected function __construct(
        string|null $suffix = null,
        private readonly bool $isNullable = false,
    ) {
        parent::__construct($suffix);
    }

    protected function type(): BaseInputType
    {
        return Type::string();
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): array|callable
    {
        return $this->options([
            $this->fieldEq(),
            $this->fieldIn(),
            $this->fieldLt(),
            $this->fieldGt(),
            $this->fieldNeq(),
            $this->fieldNin(),
            $this->fieldLte(),
            $this->fieldGte(),
            $this->fieldLike(),
            $this->fieldNotLike(),
            ($this->isNullable ? $this->fieldIsNull() : null),
        ]);
    }
}
