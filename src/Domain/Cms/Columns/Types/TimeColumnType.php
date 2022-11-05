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
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\TimePickerInputComponent;

class TimeColumnType extends AbstractColumnType
{
    private array $validation = [
        'string', 'date_format:H:i:s'
    ];

    protected function getOptions(): Collection
    {
        return Collection::make([
            new NullableTimestampColumnOption(
                'time'
            ),
            new DefaultTimestampColumnOption(
                $this->validation
            ),
            new RowColColumnOption()
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'time';
    }

    /**
     * @inheritDoc
     */
    public function getColumnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable()
            ->setFormat(function (Model $data, string $key) {
                $value = $data->getAttribute($key);

                if (!is_null($value)) {
                    if (!$value instanceof Carbon) {
                        $value = new Carbon($value);
                    }

                    return $value->format('H:i:s');
                }

                return null;
            });
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(CmsModel $model): TimePickerInputComponent
    {
        return TimePickerInputComponent::create()
            ->setUseSeconds()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setValue($model->getAttribute($this->column->key))
            ->setClearable($this->getPropertyValue('nullable', true));
    }

    /**
     * @inheritDoc
     */
    protected function getValidation(FormRequest $request): array
    {
        return $this->validation;
    }
}