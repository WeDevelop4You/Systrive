<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\DataTables\TranslationTable;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\DataTable\Build\DataTable;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationTableController extends AbstractTableController
    {
        protected function getDataTable(): AbstractTable
        {
            return TranslationTable::create();
        }

        /**
         * @param string $environment
         *
         * @return JsonResponse
         */
        public function index(string $environment): JsonResponse
        {
            return DataTable::create($this->getDataTable())
                ->query(TranslationKey::whereEnvironment($environment)->with('translations'))
                ->export();
        }
    }
