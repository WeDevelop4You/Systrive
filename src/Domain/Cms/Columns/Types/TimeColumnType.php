<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultTimestampColumnOption;
use Domain\Cms\Columns\Options\Nullables\NullableTimestampColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Graphql\Inputs\FilterTypes\CmsFilterTypeDatetimeInput;
use Domain\Cms\Models\CmsModel;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\TimePickerInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class TimeColumnType extends AbstractColumnType
{
    protected function options(): Collection
    {
        return Collection::make([
            new NullableTimestampColumnOption(
                'time'
            ),
            new DefaultTimestampColumnOption(),
            new RowColColumnOption(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'time';
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
        return CmsFilterTypeDatetimeInput::create(
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
            ->setFormat(function (Model $data, string $key) {
                $value = $data->getAttribute($key);

                if (!\is_null($value)) {
                    if (!$value instanceof Carbon) {
                        $value = new Carbon($value);
                    }

                    return $value->format('H:i:s');
                }

                return null;
            });
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): TimePickerInputComponent
    {
        return TimePickerInputComponent::create()
            ->setUseSeconds()
            ->setValue($model->getAttribute($this->getKey()))
            ->setClearable($this->getPropertyValueNullable());
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(['string', 'date_format:H:i:s']);
    }
}
