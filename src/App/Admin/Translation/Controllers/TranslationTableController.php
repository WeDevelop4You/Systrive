<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\DataTable\TranslationTable;
    use App\Admin\Translation\Resources\TranslationKeyDataResource;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Data\Build\DataTable;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationTableController
    {
        /**
         * @param string $environment
         *
         * @return AnonymousResourceCollection
         */
        public function index(string $environment): AnonymousResourceCollection
        {
            return DataTable::create(TranslationKey::whereEnvironment($environment))
                ->setColumns(TranslationTable::create())
                ->getData(TranslationKeyDataResource::class);
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
    }
