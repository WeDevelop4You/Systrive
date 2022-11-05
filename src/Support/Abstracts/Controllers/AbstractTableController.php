<?php

namespace Support\Abstracts\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Support\Abstracts\AbstractTable;
use Support\Helpers\DataTable\Build\Column;

abstract class AbstractTableController
{
    /**
     * @var string
     */
    protected string $dataTable;

    /**
     * @param mixed ...$arguments
     *
     * @return JsonResponse
     */
    final protected function headers(...$arguments): JsonResponse
    {
        $table = $this->structure(...$arguments);
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
     * @param mixed ...$arguments
     *
     * @return AbstractTable
     */
    protected function structure(...$arguments): AbstractTable
    {
        return App::call([$this->dataTable, 'create'], $arguments);
    }
}
