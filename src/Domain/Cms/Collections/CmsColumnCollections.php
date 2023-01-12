<?php

namespace Domain\Cms\Collections;

use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection as CollectionBase;

class CmsColumnCollections extends Collection
{
    /**
     * @return CollectionBase
     */
    public function createTableStructure(): CollectionBase
    {
        return $this->map(function (CmsColumn $column, int $index) {
            $component = $column->type()->getColumnComponent();

            if (($this->count() - 1) === $index) {
                $component->setDivider();
            }

            return $component;
        });
    }

    /**
     * @param CmsModel $model
     * @param bool     $readonly
     *
     * @return CollectionBase
     */
    public function createFormStructure(CmsModel $model, bool $readonly = false): CollectionBase
    {
        return $this->map(function (CmsColumn $column) use ($model, $readonly) {
            return $column->type()->getInputComponent($model, $readonly);
        });
    }

    /**
     * @param FormRequest $request
     *
     * @return CollectionBase
     */
    public function createFormRules(FormRequest $request): CollectionBase
    {
        return $this->mapWithKeys(function (CmsColumn $column) use ($request) {
            return [$column->key => $column->type()->getValidations($request)];
        });
    }
}
