<?php

namespace Domain\User\Models;

use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyUser;
use Domain\Git\Models\GitAccount;
use Domain\Role\Mappings\RoleTableMap;
use Domain\User\Collections\UserCollections;
use Domain\User\Mappings\UserTableMap;
use Domain\User\Observers\UserUpdatingObserver;
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
use Support\Traits\Observers;

/**
 * Domain\User\Models\User.
 *
 * @property int         $id
 * @property string      $email
 * @property string      $locale
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Company[]|\Domain\Company\Collections\CompanyCollections $companies
 * @property-read CompanyUser[]|\Illuminate\Database\Eloquent\Collection $companyUser
 * @property-read string|null $full_name
 * @property-read GitAccount[]|\Illuminate\Database\Eloquent\Collection $gitAccounts
 * @property-read DatabaseNotification[]|DatabaseNotificationCollection $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Domain\User\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Domain\User\Models\UserSecurity|null $security
 *
 * @method static UserCollections|static[] all($columns = ['*'])
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static UserCollections|static[] get($columns = ['*'])
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
    use Observers;
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
        UserTableMap::EMAIL,
        UserTableMap::EMAIL_VERIFIED_AT,
        UserTableMap::LOCALE,
        UserTableMap::PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        UserTableMap::PASSWORD,
        UserTableMap::REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        UserTableMap::EMAIL_VERIFIED_AT => 'datetime',
    ];

    /**
     * @var array|string[]
     */
    protected array $observers = [
        UserUpdatingObserver::class,
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

    public function isNewUser(): bool
    {
        return is_null($this->password);
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
            ->withPivot(CompanyUserTableMap::STATUS);
    }

    /**
     * @param CompanyUserStatusTypes $status
     *
     * @return BelongsToMany
     */
    public function whereCompanyStatus(CompanyUserStatusTypes $status): BelongsToMany
    {
        return $this->companies()
            ->wherePivot(CompanyUserTableMap::STATUS, $status->value);
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
     * @return UserCollections
     */
    public function newCollection(array $models = []): UserCollections
    {
        return new UserCollections($models);
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
