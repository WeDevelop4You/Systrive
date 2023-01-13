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
use Support\Client\Components\Forms\Inputs\DatetimePickerInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class DatetimeColumnType extends AbstractColumnType
{
    private array $validation = [
        'string', 'date_format:Y-m-d H:i:s',
    ];

    protected function options(): Collection
    {
        return Collection::make([
            new NullableTimestampColumnOption(
                'datetime'
            ),
            new DefaultTimestampColumnOption(
                $this->validation
            ),
            new RowColColumnOption(),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'dateTime';
    }

    /**
     * @inheritDoc
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable()
            ->setFormat(function (Model $data, string $key) {
                $value = $data->getAttribute($key);

                if (!\is_null($value)) {
                    if (!$value instanceof Carbon) {
                        $value = new Carbon($value);
                    }

                    return $value->format('d-m-Y H:i:s');
                }

                return null;
            });
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(CmsModel $model): DatetimePickerInputComponent
    {
        return DatetimePickerInputComponent::create()
            ->setUseSeconds()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setValue($model->getAttribute($this->column->key))
            ->setClearable($this->getPropertyValue('nullable', true));
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations($this->validation);
    }
}
