<?php

    namespace Support\Rules;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\Translation\Translator;
    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Database\Query\Builder as QueryBuilder;
    use Illuminate\Database\Eloquent\Relations\Relation;

    class BelongsToManyExistsRule implements Rule
    {
        /**
         * BelongsToManyExists constructor.
         *
         * @param Relation|EloquentBuilder|QueryBuilder $relatedQuery
         * @param Relation|EloquentBuilder|QueryBuilder $pivotQuery
         * @param string                                $pivotColumn
         * @param string|null                           $column
         * @param bool                                  $exists
         */
        public function __construct(
            private Relation|EloquentBuilder|QueryBuilder $relatedQuery,
            private Relation|EloquentBuilder|QueryBuilder $pivotQuery,
            private string $pivotColumn,
            private ?string $column = null,
            private bool $exists = true
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

                $searchValue = $this->relatedQuery->where($column, $value)->firstOrFail();

                return $this->exists === $this->pivotQuery->wherePivot($this->pivotColumn, $searchValue->id)->exists();
            } catch (ModelNotFoundException) {
                return !$this->exists;
            }
        }

        /**
         * @return Application|array|string|Translator|null
         */
        public function message(): array|string|Translator|Application|null
        {
            return $this->exists
                ? trans('validation.exists')
                : trans('validation.exists_not');
        }
    }
