<?php

    namespace Support\Abstracts\Controllers;

    use Illuminate\Http\JsonResponse;
    use function response;
    use Support\Abstracts\AbstractTable;

    abstract class AbstractTableController
    {
        /**
         * @return JsonResponse
         */
        final public function headers(): JsonResponse
        {
            $table = $this->getDataTable();

            return response()->json([
                'headers' => $table->getHeaders(),
                'customItems' => $table->getFormattedColumnNames(),
            ]);
        }

        /**
         * @return AbstractTable
         */
        abstract protected function getDataTable(): AbstractTable;
    }
