<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\DataTables\TranslationTable;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Client\DataTable\Table;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationTableController extends AbstractTableController
    {
        protected string $dataTable = TranslationTable::class;

        /**
         * @param string $environment
         *
         * @return JsonResponse
         */
        public function index(string $environment): JsonResponse
        {
            return $this->headers();
        }

        /**
         * @param string $environment
         *
         * @return JsonResponse
         */
        public function action(string $environment): JsonResponse
        {
            return Table::create($this->structure())
                ->query(TranslationKey::whereEnvironment($environment)->with('translations'))
                ->export();
        }
    }
