<?php

namespace Domain\Cms\Actions;

use Domain\Cms\DataTransferObjects\CmsTableData;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class CmsTableUpdateAction
{
    public const REFRESH_ALL = 1;
    public const REFRESH_TABLE = 2;

    private readonly Builder $schema;

    private int $status = self::REFRESH_TABLE;

    public function __construct(
        private readonly CmsTable $table
    ) {
        $this->schema = Schema::connection('cms');
    }

    /**
     * @param CmsTableData $data
     *
     * @throws Exception
     *
     * @return int
     */
    public function __invoke(CmsTableData $data): int
    {
        try {
            $this->table($data);
            $this->columns($data->columns);
        } catch (Exception $e) {
            throw $e;
        }

        return $this->status;
    }

    /**
     * @param CmsTableData $data
     *
     * @return void
     */
    private function table(CmsTableData $data): void
    {
        $this->table->name = $data->name;
        $this->table->label = $data->label;
        $this->table->editable = $data->editable;

        $dirtyName = $this->table->isDirty(CmsTableTableMap::COL_NAME);
        $dirtyLabel = $this->table->isDirty(CmsTableTableMap::COL_LABEL);

        if ($dirtyName) {
            $original = $this->table->getOriginal(CmsTableTableMap::COL_NAME);

            $this->schema->rename($original, $this->table->name);
        }

        if ($dirtyName || $dirtyLabel) {
            $this->status = self::REFRESH_ALL;
        }

        $this->table->save();
    }

    /**
     * @param Collection $columns
     *
     * @return void
     */
    private function columns(Collection $columns): void
    {
        $after = null;
        $existingColumns = $this->deleteColumns($columns);

        $columns->map(function (CmsColumn $column) use ($existingColumns) {
            $existingColumn = $existingColumns->firstWhere(
                CmsColumnTableMap::COL_KEY,
                $column->getAttribute(CmsColumnTableMap::COL_ORIGINAL_KEY)
            );

            if ($existingColumn instanceof CmsColumn) {
                if (!\in_array($existingColumn->key, CmsTableTableMap::REQUIRED_COLUMNS)) {
                    $existingColumn->key = $column->key;
                    $existingColumn->type = $column->type;
                    $existingColumn->label = $column->label;
                    $existingColumn->editable = $column->editable;
                    $existingColumn->properties = $column->properties;
                }

                $existingColumn->after = $column->after;
                $existingColumn->hidden = $column->hidden;

                return $existingColumn;
            }

            $column->table_id = $this->table->id;

            $column->offsetUnset(CmsColumnTableMap::COL_ORIGINAL_KEY);

            return $column;
        })
            ->sortBy(CmsColumnTableMap::COL_AFTER)
            ->each(function (CmsColumn $column, int $index) use (&$after) {
                $this->schema->table($this->table->name, function (Blueprint $table) use ($column, $index, $after) {
                    $type = $column->type();

                    $dirtyKey = $column->isDirty(CmsColumnTableMap::COL_KEY);
                    $dirtyType = $column->isDirty(CmsColumnTableMap::COL_TYPE);
                    $dirtyAfter = $column->isDirty(CmsColumnTableMap::COL_AFTER);

                    if ($dirtyKey && $column->exists) {
                        $original = $column->getOriginal(CmsColumnTableMap::COL_KEY);

                        $table->renameColumn($original, $column->key);
                    }

                    if ($dirtyType || $dirtyAfter || $type->isPropertiesDirty()) {
                        $definition = $type->getDefinition($table);

                        if ($dirtyAfter) {
                            $index > 0 ? $definition->after($after) : $definition->first();
                        }

                        if ($column->exists) {
                            $definition->change();
                        }
                    }
                });

                $after = $column->key;

                $column->save();
            });
    }

    /**
     * @param Collection $columns
     *
     * @return array|Collection
     */
    private function deleteColumns(Collection $columns): Collection|array
    {
        $keys = $columns->pluck(CmsColumnTableMap::COL_ORIGINAL_KEY)->toArray();

        return $this->table->columns->filter(function (CmsColumn $column) use ($keys) {
            if (
                \in_array($column->key, $keys) ||
                \in_array($column->key, CmsTableTableMap::REQUIRED_COLUMNS)
            ) {
                return true;
            }

            $this->schema->table(
                $this->table->name,
                fn (Blueprint $table) => $table->dropColumn($column->key)
            );

            $column->delete();

            return false;
        });
    }
}
