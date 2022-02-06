<?php

    namespace App\Admin\Translation\DataTable;

    use Illuminate\Database\Eloquent\Builder;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;
    use WeDevelop4You\TranslationFinder\Models\Translation;

    class TranslationTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function columns(): array
        {
            return [
                Column::create('key')->sortable()->searchable(),
                Column::create('group')->sortable()->searchable(),
                Column::create('tags')->sortable()->searchable(),
                Column::create('translated')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(Translation::selectRaw('MAX(locale)')->whereColumn('translation_keys.id', 'translations.translation_id'), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('translations', function (Builder $query) use ($search) {
                        return $query->where('locale', 'like', "%{$search}%");
                    });
                }),
            ];
        }
    }
