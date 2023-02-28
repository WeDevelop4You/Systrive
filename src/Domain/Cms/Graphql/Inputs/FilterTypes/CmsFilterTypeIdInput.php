<?php

namespace Domain\Cms\Graphql\Inputs\FilterTypes;

use GraphQL\Type\Definition\InputType as BaseInputType;
use GraphQL\Type\Definition\Type;

class CmsFilterTypeIdInput extends CmsFilterTypeInput
{
    protected function type(): BaseInputType
    {
        return Type::id();
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): array|callable
    {
        return [
            $this->fieldEq(),
            $this->fieldIn(),
            $this->fieldNeq(),
            $this->fieldNin(),
        ];
    }
}
