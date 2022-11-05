<?php

namespace Domain\User\Models;

use Domain\User\Mappings\UserSecurityTableMap;
use Illuminate\Database\Eloquent\Model;
use Support\Casts\EncryptionCast;

/**
 * Domain\User\Models\UserSecurity.
 *
 * @property int                                 $user_id
 * @property \Support\Helpers\DecryptHelper      $secret_key
 * @property \Support\Helpers\DecryptHelper|null $recovery_codes
 * @property bool                                $enabled
 * @property \Illuminate\Support\Carbon|null     $created_at
 * @property \Illuminate\Support\Carbon|null     $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserSecurity extends Model
{
    protected $table = 'user_security';

    protected $primaryKey = UserSecurityTableMap::USER_ID;

    protected $fillable = [
        UserSecurityTableMap::ENABLED,
        UserSecurityTableMap::SECRET_KEY,
        UserSecurityTableMap::RECOVERY_CODES,
    ];

    protected $casts = [
        UserSecurityTableMap::ENABLED => 'boolean',
        UserSecurityTableMap::SECRET_KEY => EncryptionCast::class,
        UserSecurityTableMap::RECOVERY_CODES => EncryptionCast::class.':true',
    ];
}
