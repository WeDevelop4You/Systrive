<?php

namespace Domain\Invite\Models;

use Domain\Company\Models\Company;
use Domain\Invite\Enums\InviteTypes;
use Domain\Invite\Mappings\InviteTableMap;
use Domain\Invite\Observers\InviteCreatedObserver;
use Domain\Invite\QueryBuilders\InviteQueryBuilders;
use Domain\User\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Support\Traits\Observers;

/**
 * Domain\Invite\Models\Invite.
 *
 * @property int         $company_id
 * @property int         $user_id
 * @property string      $token
 * @property InviteTypes $type
 * @property string      $created_at
 * @property-read Company $company
 * @property-read User $user
 *
 * @method static InviteQueryBuilders|Invite newModelQuery()
 * @method static InviteQueryBuilders|Invite newQuery()
 * @method static InviteQueryBuilders|Invite query()
 * @method static InviteQueryBuilders|Invite whereCompanyId($value)
 * @method static InviteQueryBuilders|Invite whereCompanyType()
 * @method static InviteQueryBuilders|Invite whereCreatedAt($value)
 * @method static InviteQueryBuilders|Invite whereExpired()
 * @method static InviteQueryBuilders|Invite whereInviteByEmailAndCompany(string $email, \Domain\Company\Models\Company $company)
 * @method static InviteQueryBuilders|Invite whereInviteByUserAndCompany(\Domain\User\Models\User $user, \Domain\Company\Models\Company $company)
 * @method static InviteQueryBuilders|Invite whereToken($value)
 * @method static InviteQueryBuilders|Invite whereType($value)
 * @method static InviteQueryBuilders|Invite whereUserByEmail(string $email)
 * @method static InviteQueryBuilders|Invite whereUserId($value)
 * @method static InviteQueryBuilders|Invite whereUserType()
 * @mixin Eloquent
 */
class Invite extends Model
{
    use Observers;

    public $timestamps = false;

    protected $table = 'invites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        InviteTableMap::TOKEN,
        InviteTableMap::TYPE,
        InviteTableMap::USER_ID,
        InviteTableMap::COMPANY_ID,
    ];

    protected $casts = [
        InviteTableMap::TYPE => InviteTypes::class,
    ];

    protected array $observers = [
        'created' => InviteCreatedObserver::class,
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
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
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
