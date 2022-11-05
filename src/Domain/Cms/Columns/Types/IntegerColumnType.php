<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultIntegerColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\AbstractInputComponent;
use Support\Response\Components\Forms\Inputs\NumberInputComponent;

class IntegerColumnType extends AbstractColumnType
{
    private array $validation = [
        'integer',
        'max:2147483647',
        'gte:-2147483648'
    ];

    protected function getOptions(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new DefaultIntegerColumnOption(
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
        return 'integer';
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
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @inheritDoc
     */
    protected function getValidation(FormRequest $request): array
    {
        return $this->validation;
    }
}
