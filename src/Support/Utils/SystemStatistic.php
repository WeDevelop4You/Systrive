<?php

namespace Support\Utils;

use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Models\SystemUsageStatistic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SystemStatistic
{
    private SystemUsageStatistic $systemUsageStatistic;

    /**
     * SystemStatisticHelper constructor.
     *
     * @param Model $model
     */
    private function __construct(Model $model)
    {
        $this->systemUsageStatistic = new SystemUsageStatistic();
        $this->systemUsageStatistic->date = Carbon::yesterday();
        $this->systemUsageStatistic->statisticFrom()->associate($model);
    }

    /**
     * @param Model $model
     *
     * @return SystemStatistic
     */
    public static function create(Model $model): SystemStatistic
    {
        return new static($model);
    }

    /**
     * @param SystemUsageStatisticTypes $type
     *
     * @return $this
     */
    public function setType(SystemUsageStatisticTypes $type): SystemStatistic
    {
        $this->systemUsageStatistic->type = $type;

        return $this;
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    public function setTotal(int $total): SystemStatistic
    {
        $this->systemUsageStatistic->total = $total;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->systemUsageStatistic->attributesToArray();
    }
}
