<?php

namespace Domain\Cms\Models;

use Doctrine\DBAL\Exception;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsFileTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

/**
 * Domain\Cms\Models\CmsTable.
 *
 * @property int                             $id
 * @property string                          $label
 * @property string                          $name
 * @property bool                            $editable
 * @property bool                            $is_table
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\Cms\Collections\CmsColumnCollection|\Domain\Cms\Models\CmsColumn[] $columns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection|\Domain\Cms\Models\CmsColumn[] $formColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection|\Domain\Cms\Models\CmsColumn[] $tableColumns
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereIsTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @property-read \Domain\Cms\Collections\CmsColumnCollection|\Domain\Cms\Models\CmsColumn[] $fileColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection|\Domain\Cms\Models\CmsColumn[] $fillableColumns
 */
class CmsTable extends Model
{
    /**
     * @var array
     */
    protected array $indexes;

    /**
     * @var string
     */
    protected $connection = 'cms';

    /**
     * @var string
     */
    protected $table = 'cms_tables';

    protected $fillable = [
        CmsTableTableMap::COL_LABEL,
        CmsTableTableMap::COL_NAME,
        CmsTableTableMap::COL_EDITABLE,
        CmsTableTableMap::COL_IS_TABLE,
    ];

    protected $casts = [
        CmsTableTableMap::COL_EDITABLE => 'boolean',
        CmsTableTableMap::COL_IS_TABLE => 'boolean',
    ];

    /**
     * @return string
     */
    public function identifier(): string
    {
        return md5($this->id);
    }

    /**
     * @return bool
     */
    public function isBackup(): bool
    {
        return ! $this->is_table;
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function indexes(): array
    {
        if (! isset($this->indexes)) {
            $this->indexes = Schema::connection('cms')
                ->getConnection()
                ->getDoctrineSchemaManager()
                ->listTableIndexes($this->name);
        }

        return $this->indexes;
    }

    public function columns(): HasMany
    {
        return $this->hasMany(CmsColumn::class, CmsColumnTableMap::COL_TABLE_ID);
    }

    /**
     * @return HasMany
     */
    public function formColumns(): HasMany
    {
        return $this->columns()->editable()->sorted();
    }

    /**
     * @return HasMany
     */
    public function tableColumns(): HasMany
    {
        return $this->columns()->visible()->sorted();
    }

    /**
     * @return HasMany
     */
    public function fileColumns(): HasMany
    {
        return $this->columns()->editable()->fileType();
    }

    /**
     * @return HasMany
     */
    public function fillableColumns(): HasMany
    {
        return $this->columns()->editable()->fileType(false);
    }

    /**
     * @return HasMany
     */
    public function selectableColumns(): HasMany
    {
        return $this->columns()->visible()->fileType(false);
    }

    public function files(): Builder
    {
        return CmsFile::where(
            CmsFileTableMap::COL_TABLE_TYPE,
            $this->identifier()
        );
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param string      $childType
     * @param mixed       $value
     * @param string|null $field
     *
     * @return Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field): ?Model
    {
        if ($childType == 'item') {
            return match ($childType) {
                'item' => CmsModel::where($field ?? CmsModel::getModel()->getKeyName(), $value)->firstOrFail(),
            };
        }

        return parent::resolveChildRouteBinding($childType, $value, $field);
    }
}
