<?php

namespace App\Admin\Translation\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Support\Abstracts\AbstractTable;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\GroupBadgesComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;
use WeDevelop4You\TranslationFinder\Models\Translation;
use WeDevelop4You\TranslationFinder\Models\TranslationKey;

class TranslationTable extends AbstractTable
{
    /**
     * {@inheritDoc}
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
                    return GroupBadgesComponent::create()
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
                    return GroupBadgesComponent::create()
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
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()
                                        ->dispatch(
                                            'translations/edit',
                                            route('admin.translation.edit', [
                                                $data->id,
                                            ])
                                        )
                                ),
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                ->setAction(
                                    RequestAction::create()
                                        ->get(route('admin.translation.destroy', [
                                            $data->id,
                                        ]))
                                ),
                        ]);
                }),
        ];
    }
}
