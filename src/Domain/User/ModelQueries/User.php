<?php

    namespace Domain\User\ModelQueries;

    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Company\Models\CompanyUser;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Domain\User\ModelQueries\User.
 *
 * @property int                             $id
 * @property string                          $email
 * @property string                          $locale
 * @property string|null                     $email_verified_at
 * @property string|null                     $password
 * @property string|null                     $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $deleted_at
 * @property-read Company[]|\Domain\Company\Collections\CompanyCollections $companies
 * @property-read string|null $full_name
 * @property-read UserProfile|null $profile
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
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
}
