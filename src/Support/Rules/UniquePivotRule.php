<?php

namespace Support\Rules;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UniquePivotRule implements Rule
{
    /**
     * BelongsToManyExists constructor.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $relatedQuery
     * @param EloquentBuilder|QueryBuilder|Relation $pivotQuery
     * @param string                                $pivotColumn
     * @param string|null                           $column
     */
    public function __construct(
            private readonly Relation|EloquentBuilder|QueryBuilder $relatedQuery,
            private readonly Relation|EloquentBuilder|QueryBuilder $pivotQuery,
            private readonly string $pivotColumn,
            private readonly ?string $column = null,
        ) {
            //
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $column = $this->column ?: $attribute;

            $relatedModel = $this->relatedQuery->where($column, $value)->firstOrFail();

            return !$this->pivotQuery->where($this->pivotColumn, $relatedModel->getKey())->exists();
        } catch (ModelNotFoundException) {
            return true;
        }
    }

    /**
     * @return Application|array|string|Translator|null
     */
    public function message(): array|string|Translator|Application|null
    {
        return trans('validation.unique');
    }
}
