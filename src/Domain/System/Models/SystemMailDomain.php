<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemMailDomainTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\System\Models\SystemMailDomain.
 *
 * @property int                             $id
 * @property int                             $system_id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemMailDomain extends Model
{
    protected $table = 'system_mail_domains';

    protected $fillable = [
        SystemMailDomainTableMap::NAME,
        SystemMailDomainTableMap::SYSTEM_USER_ID,
    ];
}
