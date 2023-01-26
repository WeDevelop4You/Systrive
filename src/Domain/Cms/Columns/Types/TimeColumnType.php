<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultTimestampColumnOption;
use Domain\Cms\Columns\Options\Nullables\NullableTimestampColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
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
            ->setClearable($this->getPropertyValue('nullable', true));
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations(['string', 'date_format:H:i:s']);
    }
}
