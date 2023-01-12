<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultIntegerColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Client\DataTable\Build\Column;

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
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'integer';
    }

    /**
     * @inheritDoc
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable();
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setDefaultValue($this->getPropertyValueDefault())
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): array
    {
        return $this->validation;
    }
}
