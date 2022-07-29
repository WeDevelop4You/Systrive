<?php

namespace Domain\Job\QueryBuilders;

use DB;
use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Mappings\JobOperationTableMap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class JobOperationQueryBuilders extends Builder
{
    /**
     * @param string $uuid
     *
     * @return Builder|JobOperationQueryBuilders
     */
    public function whereScheduleWithChildUuid(string $uuid): JobOperationQueryBuilders|Builder
    {
        return $this->where(JobOperationTableMap::ID, function (QueryBuilder $query) use ($uuid) {
            $query->select(alias('child', JobOperationTableMap::PARENT_ID))
                    ->from(JobOperationTableMap::TABLE, 'child')
                    ->where(alias('child', JobOperationTableMap::UUID), $uuid);
        })
            ->where(function (QueryBuilder $query) {
                $query->select(DB::raw('COUNT(*)'))
                    ->from(JobOperationTableMap::TABLE, 'children')
                    ->whereColumn(JobOperationTableMap::TABLE_ID, alias('children', JobOperationTableMap::PARENT_ID))
                    ->whereIn(alias('children', JobOperationTableMap::STATUS), [
                        JobOperationStatusTypes::RETRY,
                        JobOperationStatusTypes::WAITING,
                        JobOperationStatusTypes::PROCESSING,
                    ]);
            }, 0);
    }
}
