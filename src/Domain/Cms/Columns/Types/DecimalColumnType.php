<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultIntegerColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Columns\Options\PlacesColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Columns\Options\TotalColumnOption;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Rules\NumericFormatRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Client\DataTable\Build\Column;

class DecimalColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new DefaultIntegerColumnOption(
                ['numeric', new NumericFormatRule(65, 30)]
            ),
            new TotalColumnOption(
                ['integer', 'min:1', 'max:65']
            ),
            new PlacesColumnOption(
                ['integer', 'min:0', 'max:30']
            ),
            new RowColColumnOption(),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'decimal';
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
            ->setValue($model->getAttribute($this->column->key))
            ->setNumeric($this->getTotalValue(), $this->getPlacesValue());
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): array
    {
        return [
            'numeric',
            new NumericFormatRule($this->getTotalValue(), $this->getPlacesValue()),
        ];
    }

    public function getTotalValue()
    {
        return $this->getPropertyValue('total');
    }

    public function getPlacesValue()
    {
        return $this->getPropertyValue('places');
    }
}
