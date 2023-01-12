<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Defaults\DefaultStringColumnOption;
use Domain\Cms\Columns\Options\MaxLengthColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Columns\Options\UniqueColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\DataTable\Build\Column;

class StringColumnType extends AbstractColumnType
{
    /**
     * @return Collection
     */
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
            new UniqueColumnOption(),
            new DefaultStringColumnOption(),
            new MaxLengthColumnOption(Builder::$defaultStringLength),
            new RowColColumnOption(),
        ]);
    }

    /**
     * @return string
     */
    protected function type(): string
    {
        return 'string';
    }

    /**
     * @return Column
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable();
    }

    /**
     * @param CmsModel $model
     *
     * @return TextInputComponent
     */
    protected function inputComponent(CmsModel $model): TextInputComponent
    {
        return TextInputComponent::create()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @param FormRequest $request
     *
     * @return string[]
     */
    protected function validation(FormRequest $request): array
    {
        return ['string'];
    }
}
