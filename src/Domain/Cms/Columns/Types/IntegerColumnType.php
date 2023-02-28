<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultIntegerColumnOption;
use Domain\Cms\Columns\Options\Nullables\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Graphql\Inputs\FilterTypes\CmsFilterTypeIntegerInput;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class IntegerColumnType extends AbstractColumnType
{
    private array $validation = [
        'integer',
        'max:2147483647',
        'gte:-2147483648',
    ];

    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new DefaultIntegerColumnOption(
                $this->validation
            ),
            new RowColColumnOption(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'integer';
    }

    /**
     * {@inheritDoc}
     * @param string $table
     */
    protected function graphqlType(string $table): ObjectType|ListOfType|ScalarType
    {
        return Type::int();
    }

    /**
     * {@inheritDoc}
     */
    protected function graphqlFilter(): InputObjectType|null
    {
        return CmsFilterTypeIntegerInput::create(
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
            ->setSearchable();
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setDefaultValue($this->getPropertyValueDefault())
            ->setValue($model->getAttribute($this->getKey()));
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations($this->validation);
    }
}
