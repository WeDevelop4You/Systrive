<?php

namespace Domain\Cms\Graphql\Inputs\FilterTypes;

use GraphQL\Type\Definition\InputType as BaseInputType;
use GraphQL\Type\Definition\Type;

class CmsFilterTypeBooleanInput extends CmsFilterTypeInput
{
    protected function type(): BaseInputType
    {
        return Type::boolean();
    }

    /**
     * {@inheritDoc}
     */
    protected function fields(): array|callable
    {
        return [
            $this->fieldEq(),
            $this->fieldNeq(),
        ];
    }
}
