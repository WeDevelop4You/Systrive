<?php

namespace Domain\User\Models;

use Domain\User\Mappings\UserSecurityTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\User\Models\UserSecurity.
 *
 * @property int                             $user_id
 * @property string                          $secret_key
 * @property string|null                     $recovery_keys
 * @property int                             $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereRecoveryKeys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUserId($value)
 * @mixin \Eloquent
 */
class UserSecurity extends Model
{
    protected $table = 'user_security';

    protected $primaryKey = UserSecurityTableMap::USER_ID;

    protected $fillable = [
        UserSecurityTableMap::SECRET_KEY,
        UserSecurityTableMap::ENABLED,
    ];
}
