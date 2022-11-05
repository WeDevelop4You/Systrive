<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\DefaultColumnOption;
use Domain\Cms\Columns\Options\Defaults\DefaultStringColumnOption;
use Domain\Cms\Columns\Options\MaxLengthColumnOption;
use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Columns\Options\UniqueColumnOption;
use Domain\Cms\Enums\CmsColumnDefaultType;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\TextInputComponent;

class StringColumnType extends AbstractColumnType
{
    /**
     * @return Collection
     */
    protected function getOptions(): Collection
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
    protected function getType(): string
    {
        return 'string';
    }

    /**
     * @return Column
     */
    public function getColumnComponent(): Column
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
    public function getFormComponent(CmsModel $model): TextInputComponent
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
    protected function getValidation(FormRequest $request): array
    {
        return ['string'];
    }
}
