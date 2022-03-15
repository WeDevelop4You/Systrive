<?php

    namespace App\Admin\Translation\DataTables;

    use Illuminate\Database\Eloquent\Builder;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;
    use WeDevelop4You\TranslationFinder\Models\Translation;

    class TranslationTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function structure(): void
        {
            $this->structure = [
                Column::index(),
                Column::create('key', trans('word.key.key'))
                    ->sortable()
                    ->searchable(),
                Column::create('group', trans('word.group.group'))
                    ->sortable()
                    ->searchable(),
                Column::create('tags', trans('word.tags'))
                    ->sortable()
                    ->searchable(),
                Column::create('translated', trans('word.translated'))
                    ->sortable(function (Builder $query, string $direction) {
                        $query->orderBy(Translation::selectRaw('MAX(locale)')->whereColumn('translation_keys.id', 'translations.translation_id'), $direction);
                    })
                    ->searchable(function (Builder $query, string $search) {
                        $query->orWhereHas('translations', function (Builder $query) use ($search) {
                            $query->where('locale', 'like', "%{$search}%");
                        });
                    })
                    ->setDivider(),
                Column::actions(),
            ];
        }
    }
