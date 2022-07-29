<?php

    namespace App\Admin\Translation\DataTables;

    use Illuminate\Database\Eloquent\Builder;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\Component\IconTypes;
    use Support\Helpers\DataTable\Build\Column;
    use Support\Response\Actions\RequestAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Buttons\IconButtonComponent;
    use Support\Response\Components\Buttons\MultipleButtonComponent;
    use Support\Response\Components\Icons\IconComponent;
    use Support\Response\Components\Items\ItemGroupBadgesComponent;
    use WeDevelop4You\TranslationFinder\Models\Translation;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function handle(): array
        {
            return [
                Column::index(),
                Column::create(trans('word.key.key'), 'key')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.group.group'), 'group')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.tags'), 'tags')
                    ->setSortable()
                    ->setSearchable()
                    ->setFormat(function (TranslationKey $data, string $key) {
                        return ItemGroupBadgesComponent::create()
                            ->convertArray(
                                $data->getAttribute($key)
                                    ->map(fn (string $value) => ucfirst($value))
                                    ->toArray()
                            );
                    }),
                Column::create(trans('word.translated'), 'translated', 'translations')
                    ->setSortable(function (Builder $query, string $direction) {
                        $query->orderBy(Translation::selectRaw('MAX(locale)')->whereColumn('translation_keys.id', 'translations.translation_id'), $direction);
                    })
                    ->setSearchable(function (Builder $query, string $search) {
                        $query->orWhereHas('translations', function (Builder $query) use ($search) {
                            $query->where('locale', 'like', "%{$search}%");
                        });
                    })
                    ->setDivider()
                    ->setFormat(function (TranslationKey $data, string $key) {
                        return ItemGroupBadgesComponent::create()
                            ->convertArray(
                                $data->getAttribute($key)
                                    ->pluck('locale')
                                    ->map(fn (string $value) => strtoupper($value))
                                    ->toArray()
                            );
                    }),
                Column::actions()
                    ->setFormat(function (TranslationKey $data) {
                        return MultipleButtonComponent::create()
                            ->setButtons([
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PEN))
                                    ->setAction(
                                        VuexAction::create()
                                            ->dispatch(
                                                'translations/edit',
                                                route('admin.admin.translation.edit', [
                                                    $data->id,
                                                ])
                                            )
                                    ),
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TRASH))
                                    ->setAction(
                                        RequestAction::create()
                                            ->get(route('admin.admin.translation.destroy', [
                                                $data->id,
                                            ]))
                                    ),
                            ]);
                    }),
            ];
        }
    }
