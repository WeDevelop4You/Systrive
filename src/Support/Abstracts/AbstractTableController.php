<?php

    namespace Support\Abstracts;

    use Illuminate\Http\JsonResponse;

    abstract class AbstractTableController
    {
        /**
         * @return JsonResponse
         */
        final public function headers(): JsonResponse
        {
            return response()->json($this->getTableStructure()->getHeaders());
        }

        /**
         * @return AbstractTable
         */
        abstract protected function getTableStructure(): AbstractTable;
    }
