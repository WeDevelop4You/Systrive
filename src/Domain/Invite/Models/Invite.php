<?php

namespace Domain\Invite\Models;

use Domain\User\QueryBuilders\UserInviteQueryBuilders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Domain\User\Models\UserInvite.
 *
 * @property int|null $company_id
 * @property string   $email
 * @property string   $token
 * @property string   $type
 * @property string   $created_at
 *
 * @method static UserInviteQueryBuilders|Invite deleteExisting(string $email, int $companyId)
 * @method static UserInviteQueryBuilders|Invite newModelQuery()
 * @method static UserInviteQueryBuilders|Invite newQuery()
 * @method static UserInviteQueryBuilders|Invite query()
 * @method static UserInviteQueryBuilders|Invite whereCompanyId($value)
 * @method static UserInviteQueryBuilders|Invite whereCreatedAt($value)
 * @method static UserInviteQueryBuilders|Invite whereEmail($value)
 * @method static UserInviteQueryBuilders|Invite whereToken($value)
 * @method static UserInviteQueryBuilders|Invite whereType($value)
 * @mixin \Eloquent
 */
class Invite extends Model
{
    public const NEW_USER_TYPE = 'new_user';
    public const NEW_COMPANY_TYPE = 'new_company';
    public const COMPANY_USER_TYPE = 'company_user';

    public const COMPANY_USER_ACCEPTED = 'accepted';
    public const COMPANY_USER_REQUESTED = 'requested';

    public $timestamps = false;

    protected $table = 'invites';

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
