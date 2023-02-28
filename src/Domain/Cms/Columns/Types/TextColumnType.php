<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Nullables\NullableColumnOption;
use Domain\Cms\Graphql\Inputs\FilterTypes\CmsFilterTypeStringInput;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Str;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\TextareaInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class TextColumnType extends AbstractColumnType
{
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     *
     * @param string $table
     */
    protected function graphqlType(string $table): ObjectType|ListOfType|ScalarType
    {
        return Type::string();
    }

    /**
     * {@inheritDoc}
     */
    protected function graphqlFilter(): InputObjectType|null
    {
        return CmsFilterTypeStringInput::create(
            $this->getKey(),
            $this->getPropertyValueNullable()
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->getLabel(), $this->getKey())
            ->setSortable()
            ->setSearchable()
            ->setFormat(function (CmsModel $data) {
                return Str::words($data->getAttribute($this->getKey()), 3);
            });
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        return TextareaInputComponent::create()
            ->setAutoGrow()
            ->setValue($model->getAttribute($this->getKey()));
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(['string']);
    }
}
