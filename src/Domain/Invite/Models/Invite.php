<?php

namespace Domain\Invite\Models;

use Domain\Company\Models\Company;
use Domain\Invite\Mappings\InviteTableMap;
use Domain\Invite\QueryBuilders\InviteQueryBuilders;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Domain\Invite\Models\Invite.
 *
 * @property int|null $company_id
 * @property string   $email
 * @property string   $token
 * @property string   $type
 * @property string   $created_at
 * @property-read Company|null $company
 *
 * @method static InviteQueryBuilders|Invite newModelQuery()
 * @method static InviteQueryBuilders|Invite newQuery()
 * @method static InviteQueryBuilders|Invite query()
 * @method static InviteQueryBuilders|Invite whereCompanyId($value)
 * @method static InviteQueryBuilders|Invite whereCompanyType()
 * @method static InviteQueryBuilders|Invite whereCreatedAt($value)
 * @method static InviteQueryBuilders|Invite whereEmail($value)
 * @method static InviteQueryBuilders|Invite whereExpired()
 * @method static InviteQueryBuilders|Invite whereInviteByEmailAndCompany(string $email, int $companyId, ?string $type = null)
 * @method static InviteQueryBuilders|Invite whereToken($value)
 * @method static InviteQueryBuilders|Invite whereType($value)
 * @method static InviteQueryBuilders|Invite whereUserType()
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
        InviteTableMap::EMAIL,
        InviteTableMap::TOKEN,
        InviteTableMap::TYPE,
        InviteTableMap::COMPANY_ID,
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
