<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Str;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\AbstractInputComponent;
use Support\Response\Components\Forms\Inputs\TextareaInputComponent;

class TextColumnType extends AbstractColumnType
{
    protected function getOptions(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'text';
    }

    /**
     * @inheritDoc
     */
    public function getColumnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable()
            ->setFormat(function(CmsModel $data) {
                return Str::words($data->getAttribute($this->column->key), 3);
            });

    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(CmsModel $model): AbstractInputComponent
    {
        return TextareaInputComponent::create()
            ->setAutoGrow()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @inheritDoc
     */
    protected function getValidation(FormRequest $request): array
    {
        return ['string'];
    }
}
