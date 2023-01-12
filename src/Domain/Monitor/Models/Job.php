<?php

namespace Domain\Monitor\Models;

use Domain\Monitor\Mappings\JobTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Domain\Monitor\Models\Job.
 *
 * @property int      $id
 * @property string   $queue
 * @property array    $payload
 * @property int      $attempts
 * @property int|null $reserved_at
 * @property int      $available_at
 * @property Carbon   $created_at
 *
 * @method static Builder|Job newModelQuery()
 * @method static Builder|Job newQuery()
 * @method static Builder|Job query()
 * @method static Builder|Job whereAttempts($value)
 * @method static Builder|Job whereAvailableAt($value)
 * @method static Builder|Job whereCreatedAt($value)
 * @method static Builder|Job whereId($value)
 * @method static Builder|Job wherePayload($value)
 * @method static Builder|Job whereQueue($value)
 * @method static Builder|Job whereReservedAt($value)
 *
 * @mixin Eloquent
 */
class Job extends Model
{
    protected $table = 'jobs';

    protected $casts = [
        JobTableMap::COL_PAYLOAD => 'array',
    ];

    /**
     * @return string|null
     */
    public function uuid(): ?string
    {
        return Arr::get($this->payload, 'uuid');
    }

    public function displayName(): ?string
    {
        return Arr::get($this->payload, 'displayName');
    }
}
