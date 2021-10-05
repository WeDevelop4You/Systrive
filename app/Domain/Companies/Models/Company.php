<?php

    namespace Domain\Companies\Models;

    use Domain\Companies\Collections\CompanyCollections;
    use Domain\Companies\QueryBuilders\CompanyQueryBuilders;
    use Domain\User\Models\User;
    use Eloquent;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Carbon;

/**
 * Domain\Company\Models\Company
 *
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string $email
 * @property string|null $domain
 * @property string|null $information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $owner
 * @property-read Collection|User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
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
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_to_companies');
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
