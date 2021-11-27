<?php

namespace Domain\User\Models;

use Domain\User\QueryBuilders\UserInviteQueryBuilders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Domain\User\Models\UserInvite
 *
 * @property string $email
 * @property string $token
 * @property string $type
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon $created_at
 * @method static UserInviteQueryBuilders|UserInvite deleteExisting(string $email, int $companyId)
 * @method static UserInviteQueryBuilders|UserInvite newModelQuery()
 * @method static UserInviteQueryBuilders|UserInvite newQuery()
 * @method static UserInviteQueryBuilders|UserInvite query()
 * @method static UserInviteQueryBuilders|UserInvite whereCompanyId($value)
 * @method static UserInviteQueryBuilders|UserInvite whereCreatedAt($value)
 * @method static UserInviteQueryBuilders|UserInvite whereEmail($value)
 * @method static UserInviteQueryBuilders|UserInvite whereToken($value)
 * @method static UserInviteQueryBuilders|UserInvite whereType($value)
 * @mixin \Eloquent
 */
class UserInvite extends Model
{
    public const INVITE_USER_TYPE = 'user_invite';
    public const INVITE_OWNER_TYPE = 'owner_invite';

    public $timestamps = false;

    protected $table = 'user_invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
        'type',
        'company_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /**
     * @param Builder $query
     *
     * @return UserInviteQueryBuilders
     */
    public function newEloquentBuilder($query): UserInviteQueryBuilders
    {
        return new UserInviteQueryBuilders($query);
    }
}
