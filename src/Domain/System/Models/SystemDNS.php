<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemDNSTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\System\Models\SystemDNS.
 *
 * @property int                             $id
 * @property int                             $system_id
 * @property string                          $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemDNS extends Model
{
    protected $table = 'system_dns';

    protected $fillable = [
        SystemDNSTableMap::DOMAIN,
        SystemDNSTableMap::SYSTEM_ID,
    ];
}