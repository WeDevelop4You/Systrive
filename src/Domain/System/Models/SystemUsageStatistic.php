<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Domain\System\Models\SystemUsageStatistic.
 *
 * @property int         $id
 * @property string      $model_type
 * @property int         $model_id
 * @property string      $type
 * @property int         $total
 * @property string      $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Eloquent|Model $statisticFrom
 *
 * @method static Builder|SystemUsageStatistic newModelQuery()
 * @method static Builder|SystemUsageStatistic newQuery()
 * @method static Builder|SystemUsageStatistic query()
 * @method static Builder|SystemUsageStatistic whereCreatedAt($value)
 * @method static Builder|SystemUsageStatistic whereDate($value)
 * @method static Builder|SystemUsageStatistic whereId($value)
 * @method static Builder|SystemUsageStatistic whereModelId($value)
 * @method static Builder|SystemUsageStatistic whereModelType($value)
 * @method static Builder|SystemUsageStatistic whereTotal($value)
 * @method static Builder|SystemUsageStatistic whereType($value)
 * @method static Builder|SystemUsageStatistic whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SystemUsageStatistic extends Model
{
    use HasFactory;

    protected $table = 'system_usage_statistics';

    protected $fillable = [
        SystemUsageStatisticTableMap::TYPE,
        SystemUsageStatisticTableMap::TOTAL,
        SystemUsageStatisticTableMap::DATE,
    ];

    /**
     * @return MorphTo
     */
    public function statisticFrom(): MorphTo
    {
        return $this->morphTo(SystemUsageStatisticTableMap::MODEL_MORPH);
    }
}
