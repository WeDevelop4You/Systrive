<?php

namespace Domain\User\Models;

use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyUser;
use Domain\Git\Models\GitAccount;
use Domain\Role\Mappings\RoleTableMap;
use Domain\User\Collections\UserCollection;
use Domain\User\Mappings\UserTableMap;
use Domain\User\QueryBuilders\UserQueryBuilders;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

/**
 * Domain\User\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $locale
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Domain\Company\Collections\CompanyCollections|Company[] $companies
 * @property-read \Illuminate\Database\Eloquent\Collection|CompanyUser[] $companyUser
 * @property-read string|null $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|GitAccount[] $gitAccounts
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Permission\Models\Permission[] $permissions
 * @property-read \Domain\User\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Role\Models\Role[] $roles
 * @property-read \Domain\User\Models\UserSecurity|null $security
 * @method static UserCollection|static[] all($columns = ['*'])
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static UserCollection|static[] get($columns = ['*'])
 * @method static UserQueryBuilders|User newModelQuery()
 * @method static UserQueryBuilders|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static UserQueryBuilders|User permission($permissions)
 * @method static UserQueryBuilders|User query()
 * @method static UserQueryBuilders|User role($roles, $guard = null)
 * @method static UserQueryBuilders|User whereCreatedAt($value)
 * @method static UserQueryBuilders|User whereDeletedAt($value)
 * @method static UserQueryBuilders|User whereEmail($value)
 * @method static UserQueryBuilders|User whereEmailVerifiedAt($value)
 * @method static UserQueryBuilders|User whereId($value)
 * @method static UserQueryBuilders|User whereLocale($value)
 * @method static UserQueryBuilders|User wherePassword($value)
 * @method static UserQueryBuilders|User whereRememberToken($value)
 * @method static UserQueryBuilders|User whereUpdatedAt($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        UserTableMap::COL_EMAIL,
        UserTableMap::COL_EMAIL_VERIFIED_AT,
        UserTableMap::COL_LOCALE,
        UserTableMap::COL_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        UserTableMap::COL_PASSWORD,
        UserTableMap::COL_REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        UserTableMap::COL_EMAIL_VERIFIED_AT => 'datetime',
    ];

    /**
     * Get the user's preferred locale.
     *
     * @return string
     */
    public function preferredLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string|null
     */
    public function getFullNameAttribute(): ?string
    {
        return $this->profile->full_name ?? null;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleTableMap::ROLE_SUPER_ADMIN);
    }

    /**
     * @param string ...$permissions
     *
     * @return bool
     */
    public function hasPermission(string ...$permissions): bool
    {
        return $this->isSuperAdmin() || $this->hasAnyPermission(...$permissions);
    }

    /**
     * @return bool
     */
    public function isNewUser(): bool
    {
        return \is_null($this->password);
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
     * @return HasMany
     */
    public function gitAccounts(): HasMany
    {
        return $this->hasMany(GitAccount::class);
    }

    /**
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
            ->using(CompanyUser::class)
            ->withPivot(CompanyUserTableMap::COL_STATUS);
    }

    /**
     * @param CompanyUserStatusTypes $status
     *
     * @return BelongsToMany
     */
    public function whereCompanyStatus(CompanyUserStatusTypes $status): BelongsToMany
    {
        return $this->companies()
            ->wherePivot(CompanyUserTableMap::COL_STATUS, $status->value);
    }

    /**
     * @return HasMany
     */
    public function companyUser(): HasMany
    {
        return $this->hasMany(CompanyUser::class);
    }

    /**
     * @return UserFactory
     */
    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    /**
     * @param array $models
     *
     * @return UserCollection
     */
    public function newCollection(array $models = []): UserCollection
    {
        return new UserCollection($models);
    }

    /**
     * @param Builder $query
     *
     * @return UserQueryBuilders
     */
    public function newEloquentBuilder($query): UserQueryBuilders
    {
        return new UserQueryBuilders($query);
    }
}
