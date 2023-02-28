<?php

namespace Domain\Monitor\Models;

use Domain\Monitor\Enums\MonitorStatusType;
use Domain\Monitor\Events\MonitorBroadcastEvent;
use Domain\Monitor\Mappings\MonitorTableMap;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Psr\SimpleCache\InvalidArgumentException;
use Support\Traits\ModelBroadcastRateLimit;

/**
 * Domain\Monitor\Models\Monitor
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property MonitorStatusType $status
 * @property int|null $started
 * @property int|null $ended
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereEnded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUuid($value)
 * @mixin \Eloquent
 */
class Monitor extends Model
{
    use BroadcastsEvents;
    use ModelBroadcastRateLimit;

    protected $table = 'monitors';

    protected $dateFormat = 'Y-m-d H:i:s.v';

    protected string $broadcastQueue = 'broadcast-table';

    protected $fillable = [
        MonitorTableMap::COL_UUID,
        MonitorTableMap::COL_NAME,
        MonitorTableMap::COL_STATUS,
        MonitorTableMap::COL_STARTED,
        MonitorTableMap::COL_ENDED,
    ];

    protected $casts = [
        MonitorTableMap::COL_ENDED => 'integer',
        MonitorTableMap::COL_STARTED => 'integer',
        MonitorTableMap::COL_STATUS => MonitorStatusType::class,
    ];

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function duration(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes[MonitorTableMap::COL_ENDED] - $attributes[MonitorTableMap::COL_STARTED],
        )->shouldCache();
    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @param string $event
     *
     * @return array|Channel
     *
     * @throws InvalidArgumentException
     */
    public function broadcastOn($event): Channel|array
    {
        if ($this->isRateLimit()) {
            return [];
        }

        return new PrivateChannel('admin.monitor.table.channel');
    }

    /**
     * The model event's broadcast name.
     *
     * @param string $event
     *
     * @return string|null
     */
    public function broadcastAs(string $event): ?string
    {
        return 'reload';
    }

    /**
     * Get the data to broadcast for the model.
     *
     * @param string $event
     *
     * @return array
     */
    public function broadcastWith(string $event): array
    {
        return [];
    }

    /**
     * @param $event
     *
     * @return MonitorBroadcastEvent
     */
    protected function newBroadcastableEvent($event): MonitorBroadcastEvent
    {
        return new MonitorBroadcastEvent($this, $event);
    }
}
