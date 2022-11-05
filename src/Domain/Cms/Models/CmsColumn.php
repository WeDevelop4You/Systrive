<?php

namespace Domain\Cms\Models;

use Domain\Cms\Casts\CmsColumnPropertiesCast;
use Domain\Cms\Columns\Types\AbstractColumnType;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Observers\CmsColumnDeletingObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Support\Traits\Observers;

/**
 * Domain\Cms\Models\CmsColumn.
 *
 * @property int           $id
 * @property int           $table_id
 * @property string        $label
 * @property string        $key
 * @property CmsColumnType $type
 * @property int           $after
 * @property int           $editable
 * @property int           $deletable
 * @property Collection    $properties
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property-read \Domain\Cms\Models\CmsTable|null $table
 *
 * @method static Builder|CmsColumn newModelQuery()
 * @method static Builder|CmsColumn newQuery()
 * @method static Builder|CmsColumn query()
 * @method static Builder|CmsColumn whereAfter($value)
 * @method static Builder|CmsColumn whereCreatedAt($value)
 * @method static Builder|CmsColumn whereDeletable($value)
 * @method static Builder|CmsColumn whereEditable($value)
 * @method static Builder|CmsColumn whereId($value)
 * @method static Builder|CmsColumn whereKey($value)
 * @method static Builder|CmsColumn whereLabel($value)
 * @method static Builder|CmsColumn whereProperties($value)
 * @method static Builder|CmsColumn whereTableId($value)
 * @method static Builder|CmsColumn whereType($value)
 * @method static Builder|CmsColumn whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class CmsColumn extends Model
{
    use Observers;

    /**
     * @var string
     */
    protected $connection = 'cms';

    /**
     * @var string
     */
    protected $table = 'cms_columns';

    protected $fillable = [
        CmsColumnTableMap::KEY,
        CmsColumnTableMap::TYPE,
        CmsColumnTableMap::LABEL,
        CmsColumnTableMap::AFTER,
        CmsColumnTableMap::EDITABLE,
        CmsColumnTableMap::DELETABLE,
        CmsColumnTableMap::PROPERTIES,
        CmsColumnTableMap::ORIGINAL_KEY,
    ];

    protected $casts = [
        CmsColumnTableMap::TYPE => CmsColumnType::class,
        CmsColumnTableMap::PROPERTIES => CmsColumnPropertiesCast::class,
    ];

    protected array $observers = [
        CmsColumnDeletingObserver::class,
    ];

    /**
     * @return BelongsTo
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(CmsTable::class, CmsColumnTableMap::TABLE_ID_);
    }

    /**
     * @return AbstractColumnType
     */
    public function template(): AbstractColumnType
    {
        return $this->type->create($this);
    }
}
