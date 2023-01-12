<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\Nullable\NullableColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Str;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\RichTextareaInputComponent;
use Support\Client\DataTable\Build\Column;

class RichTextColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    protected function options(): Collection
    {
        return Collection::make([
            new NullableColumnOption(),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'longText';
    }

    /**
     * @inheritDoc
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setSortable()
            ->setSearchable()
            ->setFormat(function (CmsModel $data) {
                return Str::words($data->getAttribute($this->column->key), 3);
            });
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        return RichTextareaInputComponent::create()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): array
    {
        return ['string'];
    }
}
