<?php

namespace Domain\Cms\Graphql\Inputs\FilterTypes;

use GraphQL\Type\Definition\InputType as BaseInputType;
use GraphQL\Type\Definition\Type;

class CmsFilterTypeStringInput extends CmsFilterTypeInput
{
    /**
     * CmsFilterTypeStringInput constructor
     *
     * @param string|null $suffix
     * @param bool        $isNullable
     */
    protected function __construct(
        string|null $suffix = null,
        private readonly bool $isNullable = false,
    ) {
        parent::__construct($suffix);
    }

    /**
     * {@inheritdoc}
     */
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
            $this->fieldNeq(),
            $this->fieldNin(),
            $this->fieldLike(),
            $this->fieldNotLike(),
            ($this->isNullable ? $this->fieldIsNull() : null),
        ]);
    }
}
