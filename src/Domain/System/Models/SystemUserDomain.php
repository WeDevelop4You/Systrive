<?php

    namespace Domain\System\Models;

    use Domain\System\Mappings\SystemUsageStatisticTableMap;
    use Domain\System\Mappings\SystemUserDomainTableMap;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Support\Carbon;

    /**
     * Domain\System\Models\SystemUserDomain.
     *
     * @property int         $id
     * @property int         $system_user_id
     * @property string      $name
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read \Domain\System\Models\SystemUsageStatistic[]|\Illuminate\Database\Eloquent\Collection $usageStatistics
     *
     * @method static Builder|SystemUserDomain newModelQuery()
     * @method static Builder|SystemUserDomain newQuery()
     * @method static Builder|SystemUserDomain query()
     * @method static Builder|SystemUserDomain whereCreatedAt($value)
     * @method static Builder|SystemUserDomain whereId($value)
     * @method static Builder|SystemUserDomain whereName($value)
     * @method static Builder|SystemUserDomain whereSystemUserId($value)
     * @method static Builder|SystemUserDomain whereUpdatedAt($value)
     * @mixin Eloquent
     */
    class SystemUserDomain extends Model
    {
        protected $table = 'system_user_domains';

        protected $fillable = [
            SystemUserDomainTableMap::SYSTEM_USER_ID,
            SystemUserDomainTableMap::NAME,
        ];

        /**
         * @return MorphMany
         */
        public function usageStatistics(): MorphMany
        {
            return $this->morphMany(SystemUsageStatistic::class, SystemUsageStatisticTableMap::MODEL_MORPH);
        }
    }
