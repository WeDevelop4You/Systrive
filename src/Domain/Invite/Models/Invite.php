<?php

namespace Domain\Invite\Models;

use Domain\Company\Models\Company;
use Domain\Company\Scopes\CompanyViewScope;
use Domain\Company\states\AbstractCompanyState;
use Domain\Company\states\AbstractCompanyUserState;
use Domain\Invite\Enums\InviteTypes;
use Domain\Invite\Mappings\InviteTableMap;
use Domain\Invite\QueryBuilders\InviteQueryBuilders;
use Domain\User\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Domain\Invite\Models\Invite
 *
 * @property int         $company_id
 * @property int         $user_id
 * @property string      $token
 * @property InviteTypes $type
 * @property mixed       $created_at
 * @property-read Company $company
 * @property-read User $user
 *
 * @method static InviteQueryBuilders|Invite newModelQuery()
 * @method static InviteQueryBuilders|Invite newQuery()
 * @method static InviteQueryBuilders|Invite query()
 * @method static InviteQueryBuilders|Invite whereCompanyId($value)
 * @method static InviteQueryBuilders|Invite whereCreatedAt($value)
 * @method static InviteQueryBuilders|Invite whereExpired()
 * @method static InviteQueryBuilders|Invite whereInviteByEmailAndCompany(string $email, \Domain\Company\Models\Company $company)
 * @method static InviteQueryBuilders|Invite whereInviteByUserAndCompany(\Domain\User\Models\User $user, \Domain\Company\Models\Company $company)
 * @method static InviteQueryBuilders|Invite whereToken($value)
 * @method static InviteQueryBuilders|Invite whereType($value)
 * @method static InviteQueryBuilders|Invite whereTypeCompany()
 * @method static InviteQueryBuilders|Invite whereTypeUser()
 * @method static InviteQueryBuilders|Invite whereUserByEmail(string $email)
 * @method static InviteQueryBuilders|Invite whereUserId($value)
 *
 * @mixin Eloquent
 */
class Invite extends Model
{
    public $timestamps = false;

    protected $table = 'invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        InviteTableMap::COL_TOKEN,
        InviteTableMap::COL_TYPE,
        InviteTableMap::COL_USER_ID,
        InviteTableMap::COL_COMPANY_ID,
    ];

    protected $casts = [
        InviteTableMap::COL_TYPE => InviteTypes::class,
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class)->withoutGlobalScope(CompanyViewScope::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return AbstractCompanyState|AbstractCompanyUserState
     */
    public function state(): AbstractCompanyUserState|AbstractCompanyState
    {
        return $this->type->getState($this);
    }

    /**
     * @return void
     */
    public function send(): void
    {
        $this->type->sendInvite($this);
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return Carbon::parse($this->created_at)->addDays(7)->isPast();
    }

    /**
     * @param Builder $query
     *
     * @return InviteQueryBuilders
     */
    public function newEloquentBuilder($query): InviteQueryBuilders
    {
        return new InviteQueryBuilders($query);
    }
}
