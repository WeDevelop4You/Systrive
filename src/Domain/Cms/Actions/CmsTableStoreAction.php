<?php

namespace Domain\Cms\Actions;

use Domain\Cms\DataTransferObjects\CmsTableData;
use Domain\Cms\Exceptions\CmsRollbackException;
use Domain\Cms\Exceptions\CmsTableCreateException;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CmsTableStoreAction
{
    /**
     * @param CmsTableData $data
     *
     * @throws CmsTableCreateException
     * @throws CmsRollbackException
     *
     * @return CmsTable
     */
    public function __invoke(CmsTableData $data): CmsTable
    {
        $db = DB::connection('cms');
        $schema = Schema::connection('cms');

        try {
            $schema->create($data->name, function (Blueprint $table) use ($data) {
                $data->columns->each(function (CmsColumn $column) use ($table) {
                    $column->type()->getDefinition($table);
                });
            });

            $db->beginTransaction();

            $table = new CmsTable();
            $table->name = $data->name;
            $table->label = $data->label;
            $table->is_table = $data->isTable;
            $table->editable = $data->editable;
            $table->save();

            $data->columns->each(function (CmsColumn $column) use ($table) {
                $column->offsetUnset(CmsColumnTableMap::COL_ORIGINAL_KEY);

                $column->table_id = $table->id;
                $column->save();
            });

            $db->commit();

            return $table;
        } catch (Throwable $e) {
            $exception = new CmsTableCreateException('sometime went wrong while creating a table', previous: $e);

            try {
                $db->rollBack();
            } catch (Throwable) {
                $exception = new CmsRollbackException("The database couldn't rollback", previous: $exception);
            }

            $schema->dropIfExists($data->name);

            throw $exception;
        }
    }
}
