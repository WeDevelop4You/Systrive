<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultTimestampColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableTimestampColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\DatePickerInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class DateColumnType extends AbstractColumnType
{
    private array $validation = [
        'string', 'date_format:Y-m-d',
    ];

    protected function options(): Collection
    {
        return Collection::make([
            new NullableTimestampColumnOption(
                'date'
            ),
            new DefaultTimestampColumnOption(
                $this->validation,
            ),
            new RowColColumnOption(),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'date';
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

                if (! \is_null($value)) {
                    if (! $value instanceof Carbon) {
                        $value = new Carbon($value);
                    }

                    return $value->format('d-m-Y');
                }

                return null;
            });
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(CmsModel $model): DatePickerInputComponent
    {
        return DatePickerInputComponent::create()
            ->setValue($model->getAttribute($this->getKey()))
            ->setClearable($this->getPropertyValue('nullable', true));
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations($this->validation);
    }
}
