<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemUserDatabaseTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\System\Models\SystemUserDatabase.
 *
 * @property int                             $id
 * @property int                             $system_user_id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase whereSystemUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDatabase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemUserDatabase extends Model
{
    protected $table = 'system_user_databases';

    protected $fillable = [
        SystemUserDatabaseTableMap::NAME,
        SystemUserDatabaseTableMap::SYSTEM_USER_ID,
    ];
}
