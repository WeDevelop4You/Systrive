<?php

    namespace Support\Rules;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\Translation\Translator;
    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;

    class BelongsToManyExistsRule implements Rule
    {
        /**
         * BelongsToManyExists constructor.
         *
         * @param Builder|Relation $relatedQuery
         * @param Builder|Relation $pivotQuery
         * @param string           $pivotColumn
         * @param string|null      $column
         * @param bool             $exists
         */
        public function __construct(
            private Relation|Builder $relatedQuery,
            private Relation|Builder $pivotQuery,
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
            $column = $this->column ?: $attribute;

            $searchValue = $this->relatedQuery->where($column, $value)->first();

            if (is_null($searchValue)) {
                return !$this->exists;
            }

            return $this->exists === $this->pivotQuery->wherePivot($this->pivotColumn, $searchValue->id)->exists();
        }


        /**
         * @return array|Application|Translator|string|null
         */
        public function message(): array|string|Translator|Application|null
        {
            return $this->exists
                ? trans('validation.exists')
                : trans('validation.exists_not');
        }
    }
