<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Forms\Inputs\AbstractInputComponent;

class IdColumnType extends AbstractColumnType
{
    protected function getOptions(): Collection
    {
        return Collection::make();
    }

    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'id';
    }

    /**
     * @inheritDoc
     */
    public function getColumnComponent(): Column
    {
        return Column::id();
    }

    /**
     * @inheritDoc
     */
    public function getFormComponent(CmsModel $model): AbstractInputComponent
    {
        //
    }

    /**
     * @inheritDoc
     */
    protected function getValidation(FormRequest $request): array
    {
        return [];
    }
}
