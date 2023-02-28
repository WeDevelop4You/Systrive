<?php

namespace Domain\Cms\Models;

use Doctrine\DBAL\Exception;
use Domain\Cms\Collections\CmsTableCollection;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsFileTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

/**
 * Domain\Cms\Models\CmsTable
 *
 * @property int $id
 * @property string $label
 * @property string $name
 * @property string $query
 * @property bool $editable
 * @property bool $queryable
 * @property bool $mutable
 * @property bool $deletable
 * @property bool $is_table
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $columns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $fileColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $fillableColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $formColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $mutableColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $queryableColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $sortedColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $tableColumns
 * @property-read \Domain\Cms\Collections\CmsColumnCollection<int, \Domain\Cms\Models\CmsColumn> $visibleColumns
 * @method static CmsTableCollection<int, static> all($columns = ['*'])
 * @method static CmsTableCollection<int, static> get($columns = ['*'])
 * @method static Builder|CmsTable newModelQuery()
 * @method static Builder|CmsTable newQuery()
 * @method static Builder|CmsTable query()
 * @method static Builder|CmsTable whereCreatedAt($value)
 * @method static Builder|CmsTable whereDeletable($value)
 * @method static Builder|CmsTable whereEditable($value)
 * @method static Builder|CmsTable whereId($value)
 * @method static Builder|CmsTable whereIsTable($value)
 * @method static Builder|CmsTable whereLabel($value)
 * @method static Builder|CmsTable whereMutable($value)
 * @method static Builder|CmsTable whereName($value)
 * @method static Builder|CmsTable whereQuery($value)
 * @method static Builder|CmsTable whereQueryable($value)
 * @method static Builder|CmsTable whereUpdatedAt($value)
 * @mixin \Eloquent
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
        CmsTableTableMap::COL_QUERY,
        CmsTableTableMap::COL_EDITABLE,
        CmsTableTableMap::COL_QUERYABLE,
        CmsTableTableMap::COL_MUTABLE,
        CmsTableTableMap::COL_DELETABLE,
        CmsTableTableMap::COL_IS_TABLE,
    ];

    protected $casts = [
        CmsTableTableMap::COL_EDITABLE => 'boolean',
        CmsTableTableMap::COL_QUERYABLE => 'boolean',
        CmsTableTableMap::COL_MUTABLE => 'boolean',
        CmsTableTableMap::COL_DELETABLE => 'boolean',
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
        return !$this->is_table;
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function indexes(): array
    {
        if (!isset($this->indexes)) {
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
    public function sortedColumns(): HasMany
    {
        return $this->columns()->sorted();
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
    public function visibleColumns(): HasMany
    {
        return $this->columns()->visible()->fileType(false);
    }

    /**
     * @return HasMany
     */
    public function queryableColumns(): hasMany
    {
        return $this->columns()->selectable();
    }

    /**
     * @return HasMany
     */
    public function mutableColumns(): hasMany
    {
        return $this->columns()->deletable()->fileType(false)->sorted();
    }

    /**
     * @return Builder
     */
    public function files(): Builder
    {
        return CmsFile::where(
            CmsFileTableMap::COL_TABLE_TYPE,
            $this->identifier()
        );
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return CmsTableCollection
     */
    public function newCollection(array $models = []): CmsTableCollection
    {
        return new CmsTableCollection($models);
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
        return match ($childType) {
            'item' => CmsModel::where($field ?? CmsModel::getModel()->getKeyName(), $value)->firstOrFail(),
            default => parent::resolveChildRouteBinding($childType, $value, $field)
        };
    }
}
