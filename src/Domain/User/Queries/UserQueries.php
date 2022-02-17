<?php

    namespace Domain\User\Queries;

    use Domain\Company\Collections\CompanyCollections;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Company\Models\CompanyUser;
    use Domain\User\Models\UserProfile;
    use Domain\User\Models\UserSecurity;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Domain\User\Queries\UserQueries.
 *
 * @property-read Company[]|CompanyCollections $companies
 * @property-read CompanyUser[]|\Illuminate\Database\Eloquent\Collection $companyUser
 * @property-read string|null $full_name
 * @property-read UserProfile|null $profile
 * @property-read UserSecurity|null $security
 *
 * @method static Builder|UserQueries newModelQuery()
 * @method static Builder|UserQueries newQuery()
 * @method static Builder|UserQueries query()
 * @mixin Eloquent
 */
class UserQueries extends Authenticatable
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
     * @return HasOne
     */
    public function security(): HasOne
    {
        return $this->hasOne(UserSecurity::class);
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
