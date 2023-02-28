<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultStringColumnOption;
use Domain\Cms\Columns\Options\MaxLengthColumnOption;
use Domain\Cms\Columns\Options\Nullables\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Columns\Options\UniqueColumnOption;
use Domain\Cms\Graphql\Inputs\FilterTypes\CmsFilterTypeStringInput;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class StringColumnType extends AbstractColumnType
{
    /**
     * @return Collection
     */
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new UniqueColumnOption(),
            new DefaultStringColumnOption(),
            new MaxLengthColumnOption(Builder::$defaultStringLength),
            new RowColColumnOption(),
        ]);
    }

    /**
     * @return string
     */
    protected function type(): string
    {
        return 'string';
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
     * @return Column
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->getLabel(), $this->getKey())
            ->setSortable()
            ->setSearchable();
    }

    /**
     * @param CmsModel $model
     *
     * @return TextInputComponent
     */
    protected function inputComponent(CmsModel $model): TextInputComponent
    {
        return TextInputComponent::create()
            ->setValue($model->getAttribute($this->getKey()));
    }

    /**
     * @param FormRequest $request
     *
     * @return validations
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(['string']);
    }
}
