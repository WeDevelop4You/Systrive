<?php

    namespace Domain\System\Models;

    use Domain\System\Mappings\SystemUserDomainTableMap;
    use Eloquent;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;

    /**
     * Domain\System\Models\SystemUserDomain.
     *
     * @property int         $id
     * @property int         $system_user_id
     * @property string      $name
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     *
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain query()
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain whereSystemUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SystemUserDomain whereUpdatedAt($value)
     * @mixin Eloquent
     */
    class SystemUserDomain extends Model
    {
        protected $table = 'system_user_domains';

        protected $fillable = [
            SystemUserDomainTableMap::SYSTEM_USER_ID,
            SystemUserDomainTableMap::NAME,
        ];
    }
