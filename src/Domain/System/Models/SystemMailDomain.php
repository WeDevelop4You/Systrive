<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemMailDomainTableMap;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Domain\System\Models\SystemMailDomain.
 *
 * @property int                             $id
 * @property int                             $system_id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\System\Models\SystemUsageStatistic[]|\Illuminate\Database\Eloquent\Collection $usageStatistics
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemMailDomain extends Model
{
    protected $table = 'system_mail_domains';

    protected $fillable = [
        SystemMailDomainTableMap::NAME,
        SystemMailDomainTableMap::SYSTEM_ID,
    ];

    /**
     * @return MorphMany
     */
    public function usageStatistics(): MorphMany
    {
        return $this->morphMany(SystemUsageStatistic::class, SystemUsageStatisticTableMap::MORPH_MODEL);
    }
}
