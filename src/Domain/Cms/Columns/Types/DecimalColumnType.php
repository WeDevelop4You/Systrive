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
use Support\Utils\Validations;

class DecimalColumnType extends AbstractColumnType
{
    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'decimal';
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
            ->setValue($model->getAttribute($this->getKey()))
            ->setNumeric($this->getTotalValue(), $this->getPlacesValue());
    }

    /**
     * {@inheritDoc}
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations([
            'numeric',
            new NumericFormatRule($this->getTotalValue(), $this->getPlacesValue()),
        ]);
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
