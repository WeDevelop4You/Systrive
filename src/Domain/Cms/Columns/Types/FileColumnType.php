<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Columns\Options\RowColColumnOption;
use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\FileInputComponent;
use Support\Client\DataTable\Build\Column;

class FileColumnType extends AbstractColumnType
{
    protected function options(): Collection
    {
        return Collection::make([
            new RowColColumnOption()
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'foreignId';
    }

    /**
     * @inheritDoc
     */
    protected function columnComponent(): Column
    {
        return Column::create($this->column->label, $this->column->key)
            ->setFormat(function(CmsModel $data) {
                return 'test';
            });
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        return FileInputComponent::create()
            ->setMultiple()
            ->setKey($this->column->key)
            ->setLabel($this->column->label)
            ->setValue($model->getAttribute($this->column->key));
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): array
    {
        return [];
    }
}
