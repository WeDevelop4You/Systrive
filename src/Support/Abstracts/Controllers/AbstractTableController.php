<?php

    namespace Support\Abstracts\Controllers;

    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\DataTable\Build\Column;

    abstract class AbstractTableController
    {
        /**
         * @return JsonResponse
         */
        final public function headers(): JsonResponse
        {
            $table = $this->getDataTable();
            $headers = $table->getColumns()
                ->map(fn (Column $column) => $column->export())
                ->toArray();
            $customItems = $table->getColumns()
                ->filter(fn (Column $column) => $column->hasFormat)
                ->map(fn (Column $column) => $column->identifier)
                ->values()
                ->toArray();

            return response()->json([
                'headers' => $headers,
                'customItems' => $customItems,
            ]);
        }

        /**
         * @return AbstractTable
         */
        abstract protected function getDataTable(): AbstractTable;
    }
