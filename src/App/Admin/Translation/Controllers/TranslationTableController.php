<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\Resources\TranslationKeyDataResource;
    use App\Controller;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Table\Build\Column;
    use Support\Helpers\Table\Build\DataTable;
    use WeDevelop4You\TranslationFinder\Models\Translation;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationTableController extends Controller
    {
        /**
         * @param string $environment
         * @return AnonymousResourceCollection
         */
        public function index(string $environment): AnonymousResourceCollection
        {
            return DataTable::create(TranslationKey::whereEnvironment($environment))
                ->setColumns($this->createColumns())
                ->get(TranslationKeyDataResource::class);
        }

        /**
         * @return JsonResponse
         */
        public function environments(): JsonResponse
        {
            return response()->json([
                'data' => TranslationKey::select('environment')
                    ->distinct()
                    ->pluck('environment')
                    ->toArray(),
                ]);
        }

        /**
         * @return array
         */
        private function createColumns(): array
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
