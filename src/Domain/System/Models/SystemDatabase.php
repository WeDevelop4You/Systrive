<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemDatabaseTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\System\Models\SystemDatabase
 *
 * @property int $id
 * @property int $system_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemDatabase extends Model
{
    protected $table = 'system_databases';

    protected $fillable = [
        SystemDatabaseTableMap::NAME,
        SystemDatabaseTableMap::SYSTEM_ID,
    ];
}
