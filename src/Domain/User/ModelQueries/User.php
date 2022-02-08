<?php

    namespace Domain\User\ModelQueries;

    use Domain\Company\Collections\CompanyCollections;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Company\Models\CompanyUser;
    use Domain\User\Models\UserProfile;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Support\Carbon;

/**
 * Domain\User\ModelQueries\User.
 *
 * @property int         $id
 * @property string      $email
 * @property string      $locale
 * @property string|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Company[]|CompanyCollections $companies
 * @property-read CompanyUser[]|\Illuminate\Database\Eloquent\Collection $companyUser
 * @property-read string|null $full_name
 * @property-read UserProfile|null $profile
 *
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLocale($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    /**
     * @return string|null
     */
    public function getFullNameAttribute(): ?string
    {
        return $this->profile->full_name ?? null;
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
                ->using(CompanyUser::class)
                ->withPivot(CompanyUserTableMap::STATUS);
    }

    public function whereCompanyStatus(string $status): BelongsToMany
    {
        return $this->companies()
                ->wherePivot(CompanyUserTableMap::STATUS, $status);
    }

    /**
     * @return HasMany
     */
    public function companyUser(): HasMany
    {
        return $this->hasMany(CompanyUser::class);
    }
}
