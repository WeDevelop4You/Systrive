<?php

namespace Domain\Cms\Models;

use Domain\Cms\Casts\CmsColumnPropertiesCast;
use Domain\Cms\Collections\CmsColumnCollection;
use Domain\Cms\Columns\Types\AbstractColumnType;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Domain\Cms\Models\CmsColumn
 *
 * @property int           $id
 * @property int           $table_id
 * @property string        $label
 * @property string        $key
 * @property CmsColumnType $type
 * @property int           $after
 * @property int           $hidden
 * @property int           $editable
 * @property bool          $deletable
 * @property int           $selectable
 * @property int           $creatable
 * @property int           $updatable
 * @property Collection    $properties
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property-read \Domain\Cms\Models\CmsTable $table
 *
 * @method static CmsColumnCollection<int, static> all($columns = ['*'])
 * @method static Builder|CmsColumn        creatable()
 * @method static Builder|CmsColumn        deletable()
 * @method static Builder|CmsColumn        editable()
 * @method static Builder|CmsColumn        fileType(bool $not = true)
 * @method static CmsColumnCollection<int, static> get($columns = ['*'])
 * @method static Builder|CmsColumn        newModelQuery()
 * @method static Builder|CmsColumn        newQuery()
 * @method static Builder|CmsColumn        query()
 * @method static Builder|CmsColumn        selectable()
 * @method static Builder|CmsColumn        sorted()
 * @method static Builder|CmsColumn        updatable()
 * @method static Builder|CmsColumn        visible()
 * @method static Builder|CmsColumn        whereAfter($value)
 * @method static Builder|CmsColumn        whereCreatable($value)
 * @method static Builder|CmsColumn        whereCreatedAt($value)
 * @method static Builder|CmsColumn        whereDeletable($value)
 * @method static Builder|CmsColumn        whereEditable($value)
 * @method static Builder|CmsColumn        whereHidden($value)
 * @method static Builder|CmsColumn        whereId($value)
 * @method static Builder|CmsColumn        whereKey($value)
 * @method static Builder|CmsColumn        whereLabel($value)
 * @method static Builder|CmsColumn        whereProperties($value)
 * @method static Builder|CmsColumn        whereSelectable($value)
 * @method static Builder|CmsColumn        whereTableId($value)
 * @method static Builder|CmsColumn        whereType($value)
 * @method static Builder|CmsColumn        whereUpdatable($value)
 * @method static Builder|CmsColumn        whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class CmsColumn extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cms';

    /**
     * @var string
     */
    protected $table = 'cms_columns';

    protected $fillable = [
        CmsColumnTableMap::COL_KEY,
        CmsColumnTableMap::COL_TYPE,
        CmsColumnTableMap::COL_LABEL,
        CmsColumnTableMap::COL_AFTER,
        CmsColumnTableMap::COL_HIDDEN,
        CmsColumnTableMap::COL_EDITABLE,
        CmsColumnTableMap::COL_DELETABLE,
        CmsColumnTableMap::COL_PROPERTIES,
        CmsColumnTableMap::COL_ORIGINAL_KEY,
    ];

    protected $casts = [
        CmsColumnTableMap::COL_DELETABLE => 'boolean',
        CmsColumnTableMap::COL_TYPE => CmsColumnType::class,
        CmsColumnTableMap::COL_PROPERTIES => CmsColumnPropertiesCast::class,
    ];

    /**
     * @return AbstractColumnType
     */
    public function type(): AbstractColumnType
    {
        return $this->type->create($this);
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function property(string $key, mixed $default = null): mixed
    {
        return $this->type()->getPropertyValue($key, $default);
    }

    /**
     * @return BelongsTo
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(CmsTable::class, CmsColumnTableMap::COL_TABLE_ID);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy(CmsColumnTableMap::COL_AFTER);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where(CmsColumnTableMap::COL_HIDDEN, false);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEditable(Builder $query): Builder
    {
        return $query->where(CmsColumnTableMap::COL_EDITABLE, true);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeDeletable(Builder $query): Builder
    {
        return $query->where(CmsColumnTableMap::COL_DELETABLE, true);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeSelectable(Builder $query): Builder
    {
        return $query->where(CmsColumnTableMap::COL_SELECTABLE, true);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeCreatable(Builder $query): Builder
    {
        return $query->where(CmsColumnTableMap::COL_CREATABLE, true);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeUpdatable(Builder $query): Builder
    {
        return $query->where(CmsColumnTableMap::COL_UPDATABLE, true);
    }

    /**
     * @param Builder $query
     * @param bool    $not
     *
     * @return Builder
     */
    public function scopeFileType(Builder $query, bool $not = true): Builder
    {
        return $query->whereIn(CmsColumnTableMap::COL_TYPE, [
            CmsColumnType::FILE->value,
            CmsColumnType::IMAGE->value,
        ], not: !$not);
    }

    /**
     * @param string|null $key
     *
     * @return bool
     */
    public static function isRequired(string|null $key): bool
    {
        return in_array($key, CmsColumnTableMap::REQUIRED_COLUMNS);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return CmsColumnCollection
     */
    public function newCollection(array $models = []): CmsColumnCollection
    {
        return new CmsColumnCollection($models);
    }
}
