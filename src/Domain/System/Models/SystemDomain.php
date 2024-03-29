<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemDomainTableMap;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * Domain\System\Models\SystemDomain
 *
 * @property int         $id
 * @property int         $system_id
 * @property string      $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\System\Models\SystemUsageStatistic> $usageStatistics
 *
 * @method static Builder|SystemDomain newModelQuery()
 * @method static Builder|SystemDomain newQuery()
 * @method static Builder|SystemDomain query()
 * @method static Builder|SystemDomain whereCreatedAt($value)
 * @method static Builder|SystemDomain whereId($value)
 * @method static Builder|SystemDomain whereName($value)
 * @method static Builder|SystemDomain whereSystemId($value)
 * @method static Builder|SystemDomain whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class SystemDomain extends Model
{
    protected $table = 'system_domains';

    protected $fillable = [
        SystemDomainTableMap::COL_SYSTEM_ID,
        SystemDomainTableMap::COL_NAME,
    ];

    /**
     * @return MorphMany
     */
    public function usageStatistics(): MorphMany
    {
        return $this->morphMany(SystemUsageStatistic::class, SystemUsageStatisticTableMap::MORPH_MODEL);
    }
}
