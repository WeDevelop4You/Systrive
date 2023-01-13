<?php

namespace Domain\Cms\Columns\Types;

use Domain\Cms\Models\CmsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\DataTable\Build\Column;
use Support\Utils\Validations;

class IdColumnType extends AbstractColumnType
{
    protected function options(): Collection
    {
        return Collection::make();
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'id';
    }

    /**
     * @inheritDoc
     */
    protected function columnComponent(): Column
    {
        return Column::id();
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(CmsModel $model): AbstractInputComponent
    {
        //
    }

    /**
     * @inheritDoc
     */
    protected function validation(FormRequest $request): validations
    {
        return new Validations([]);
    }
}
