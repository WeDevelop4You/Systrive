<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemUserMailDomainTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\System\Models\SystemUserMailDomain.
 *
 * @property int                             $id
 * @property int                             $system_user_id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain whereSystemUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUserMailDomain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemUserMailDomain extends Model
{
    protected $table = 'system_user_mail_domains';

    protected $fillable = [
        SystemUserMailDomainTableMap::NAME,
        SystemUserMailDomainTableMap::SYSTEM_USER_ID,
    ];
}
