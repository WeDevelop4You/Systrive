<?php

namespace Domain\Cms\Actions;

use Domain\Cms\Columns\Attributes\CustomColumn;
use Domain\Cms\DataTransferObjects\CmsTableData;
use Domain\Cms\Exceptions\CmsTableException;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CmsTableStoreAction
{
    /**
     * @param CmsTableData $data
     *
     * @return CmsTable
     *
     * @throws CmsTableException
     * @throws Throwable
     */
    public function __invoke(CmsTableData $data): CmsTable
    {
        $db = DB::connection('cms');
        $schema = Schema::connection('cms');

        try {
            $schema->create($data->name, function (Blueprint $table) use ($data) {
                $data->columns->each(function (CmsColumn $column) use ($table) {
                    $type = $column->type();

                    if (!$type instanceof CustomColumn) {
                        $type->getDefinition($table);
                    }
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
                $column->table_id = $table->id;
                $column->save();
            });

            $db->commit();

            return $table;
        } catch (Exception $e) {
            $db->rollBack();

            throw new CmsTableException('Something went wrong while creating table', previous: $e);
        } finally {
            $schema->dropIfExists($data->name);
        }
    }
}
