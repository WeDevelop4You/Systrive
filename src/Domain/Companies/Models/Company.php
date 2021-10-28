<?php

    namespace Domain\Companies\Models;

    use Domain\Companies\Collections\CompanyCollections;
    use Domain\Companies\QueryBuilders\CompanyQueryBuilders;
    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Eloquent;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Carbon;

    /**
 * Domain\Companies\Models\Company
 *
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string $email
 * @property string|null $domain
 * @property string|null $information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string|null $owner_full_name
 * @property-read User $owner
 * @property-read UserProfile $ownerProfile
 * @property-read \Domain\User\Collections\UserCollections|User[] $users
 * @method static CompanyCollections|static[] all($columns = ['*'])
 * @method static CompanyCollections|static[] get($columns = ['*'])
 * @method static CompanyQueryBuilders|Company newModelQuery()
 * @method static CompanyQueryBuilders|Company newQuery()
 * @method static CompanyQueryBuilders|Company query()
 * @method static CompanyQueryBuilders|Company whereCreatedAt($value)
 * @method static CompanyQueryBuilders|Company whereDomain($value)
 * @method static CompanyQueryBuilders|Company whereEmail($value)
 * @method static CompanyQueryBuilders|Company whereId($value)
 * @method static CompanyQueryBuilders|Company whereInformation($value)
 * @method static CompanyQueryBuilders|Company whereName($value)
 * @method static CompanyQueryBuilders|Company whereOwnerId($value)
 * @method static CompanyQueryBuilders|Company whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'domain',
        'information',
        'owner_id',
    ];

    /**
     * @return string|null
     */
    public function getOwnerFullNameAttribute(): ?string
    {
        return $this->ownerProfile->full_name ?? null;
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return BelongsTo
     */
    public function ownerProfile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class, 'owner_id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @param Builder $query
     * @return CompanyQueryBuilders
     */
    public function newEloquentBuilder($query): CompanyQueryBuilders
    {
        return new CompanyQueryBuilders($query);
    }

    /**
     * @param array $models
     * @return CompanyCollections
     */
    public function newCollection(array $models = []): CompanyCollections
    {
        return new CompanyCollections($models);
    }
}
