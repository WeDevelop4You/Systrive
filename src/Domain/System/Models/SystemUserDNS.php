<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemUserDNSTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\System\Models\SystemUserDNS.
 *
 * @property int                             $id
 * @property int                             $system_user_id
 * @property string                          $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS whereSystemUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDNS whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemUserDNS extends Model
{
    protected $table = 'system_user_dns';

    protected $fillable = [
        SystemUserDNSTableMap::DOMAIN,
        SystemUserDNSTableMap::SYSTEM_USER_ID,
    ];
}
