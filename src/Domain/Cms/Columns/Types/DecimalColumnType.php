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
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\AbstractInputComponent;
use Support\Response\Components\Forms\Inputs\NumberInputComponent;

class DecimalColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    protected function getOptions(): Collection
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
    protected function getType(): string
    {
        return 'decimal';
    }

    /**
     * @inheritDoc
     */
    public function getColumnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable();
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(CmsModel $model): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setDefaultValue($this->getDefaultValue())
            ->setValue($model->getAttribute($this->column->key))
            ->setNumeric($this->getTotalValue(), $this->getPlacesValue());
    }

    /**
     * @inheritDoc
     */
    protected function getValidation(FormRequest $request): array
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
