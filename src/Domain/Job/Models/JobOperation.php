<?php

namespace Domain\Job\Models;

use Domain\Job\Collections\JobOperationCollections;
use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\QueryBuilders\JobOperationQueryBuilders;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Support\Enums\ScheduleType;

/**
 * Domain\Job\Models\JobOperation.
 *
 * @property int                     $id
 * @property ScheduleType|null       $schedule_type
 * @property int|null                $parent_id
 * @property string|null             $uuid
 * @property string|null             $name
 * @property int|null                $start_time
 * @property int|null                $end_time
 * @property JobOperationStatusTypes $status
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property-read JobOperation[]|JobOperationCollections $children
 * @property-read JobOperation|null $parent
 *
 * @method static JobOperationCollections|static[]       all($columns = ['*'])
 * @method static JobOperationCollections|static[]       get($columns = ['*'])
 * @method static JobOperationQueryBuilders|JobOperation newModelQuery()
 * @method static JobOperationQueryBuilders|JobOperation newQuery()
 * @method static JobOperationQueryBuilders|JobOperation query()
 * @method static JobOperationQueryBuilders|JobOperation whereCreatedAt($value)
 * @method static JobOperationQueryBuilders|JobOperation whereEndTime($value)
 * @method static JobOperationQueryBuilders|JobOperation whereId($value)
 * @method static JobOperationQueryBuilders|JobOperation whereName($value)
 * @method static JobOperationQueryBuilders|JobOperation whereParentId($value)
 * @method static JobOperationQueryBuilders|JobOperation whereScheduleType($value)
 * @method static JobOperationQueryBuilders|JobOperation whereScheduleWithChildUuid(string $uuid)
 * @method static JobOperationQueryBuilders|JobOperation whereStartTime($value)
 * @method static JobOperationQueryBuilders|JobOperation whereStatus($value)
 * @method static JobOperationQueryBuilders|JobOperation whereUpdatedAt($value)
 * @method static JobOperationQueryBuilders|JobOperation whereUuid($value)
 *
 * @mixin Eloquent
 */
class JobOperation extends Model
{
    protected $table = 'job_operations';

    protected $fillable = [
        JobOperationTableMap::PARENT_ID,
        JobOperationTableMap::UUID,
        JobOperationTableMap::NAME,
        JobOperationTableMap::SCHEDULE_TYPE,
        JobOperationTableMap::START_TIME,
        JobOperationTableMap::END_TIME,
        JobOperationTableMap::STATUS,
    ];

    protected $casts = [
        JobOperationTableMap::SCHEDULE_TYPE => ScheduleType::class,
        JobOperationTableMap::START_TIME => 'int',
        JobOperationTableMap::END_TIME => 'int',
        JobOperationTableMap::STATUS => JobOperationStatusTypes::class,
    ];

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, JobOperationTableMap::PARENT_ID);
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class);
    }

    /**
     * @return bool
     */
    public function isChild(): bool
    {
        return \is_null($this->schedule_type) && !\is_null($this->parent_id);
    }

    public function isParent(): bool
    {
        return !$this->isChild();
    }

    /**
     * @param $query
     *
     * @return JobOperationQueryBuilders
     */
    public function newEloquentBuilder($query): JobOperationQueryBuilders
    {
        return new JobOperationQueryBuilders($query);
    }

    /**
     * @param array $models
     *
     * @return JobOperationCollections
     */
    public function newCollection(array $models = []): JobOperationCollections
    {
        return new JobOperationCollections($models);
    }
}
