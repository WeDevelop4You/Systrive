<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\DataTables\TranslationTable;
    use App\Admin\Translation\Resources\TranslationKeyDataResource;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;
    use Support\Helpers\Response\Response;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationTableController extends AbstractTableController
    {
        protected function getTableStructure(): AbstractTable
        {
            return TranslationTable::create();
        }

        /**
         * @param string $environment
         *
         * @return AnonymousResourceCollection
         */
        public function index(string $environment): AnonymousResourceCollection
        {
            return DataTable::query(TranslationKey::whereEnvironment($environment))
                ->setColumns($this->getTableStructure())
                ->export(TranslationKeyDataResource::class);
        }

        /**
         * @return JsonResponse
         */
        public function environments(): JsonResponse
        {
            $environments = TranslationKey::select('environment')
                ->distinct()
                ->pluck('environment')
                ->toArray();

            return Response::create()
                ->addData($environments)
                ->toJson();
        }
    }
