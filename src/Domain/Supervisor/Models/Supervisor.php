<?php

namespace Domain\Supervisor\Models;

use Domain\Supervisor\Mappings\SupervisorTableMap;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Support\Services\Supervisor as SupervisorService;

/**
 * Domain\Supervisor\Models\Supervisor
 *
 * @property int $id
 * @property string $name
 * @property string $filename
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supervisor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Supervisor extends Model
{
    protected $table = SupervisorTableMap::TABLE;

    protected $fillable = [
        SupervisorTableMap::COL_NAME,
        SupervisorTableMap::COL_FILENAME,
    ];

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function config(): Attribute
    {
        return Attribute::make(
            get: fn () => SupervisorService::file()->get($this->filename) ?: '',
        );
    }

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function filename(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => "{$value}.conf"
        );
    }
}
