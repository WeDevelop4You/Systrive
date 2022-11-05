<?php

namespace Domain\Cms\Models;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Services\Cms as CmsService;

/**
 * Domain\Cms\Models\CmsTable
 *
 * @property int $id
 * @property string $label
 * @property string $name
 * @property int $editable
 * @property int $is_table
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Cms\Models\CmsColumn[] $columns
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsTable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CmsTable extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cms';

    /**
     * @var string
     */
    protected $table = 'cms_tables';

    protected $fillable = [
        CmsTableTableMap::LABEL,
        CmsTableTableMap::NAME,
        CmsTableTableMap::EDITABLE,
        CmsTableTableMap::IS_TABLE,
    ];

    protected $casts = [
        CmsTableTableMap::EDITABLE => 'boolean',
        CmsTableTableMap::IS_TABLE => 'boolean',
    ];

    public function columns(): HasMany
    {
        return $this->hasMany(CmsColumn::class, CmsColumnTableMap::TABLE_ID_);
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
        if (in_array($childType, ['item'])) {
            return match ($childType) {
                'item' => CmsModel::where($field ?? CmsModel::getModel()->getKeyName(), $value)->firstOrFail(),
            };
        }

        return parent::resolveChildRouteBinding($childType, $value, $field);
    }
}
