<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Graphql\Inputs\FilterTypes\CmsFilterTypeIdInput;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class IdColumnType extends AbstractColumnType
{
    protected function options(): Collection
    {
        return Collection::make();
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'id';
    }

    /**
     * {@inheritDoc}
     *
     * @param string $table
     */
    protected function graphqlType(string $table): ObjectType|ListOfType|ScalarType
    {
        return Type::id();
    }

    /**
     * {@inheritDoc}
     */
    protected function graphqlFilter(): InputObjectType|null
    {
        return CmsFilterTypeIdInput::create($this->getKey());
    }

    /**
     * {@inheritDoc}
     */
    protected function columnComponent(): Column
    {
        return Column::id();
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations([]);
    }
}
