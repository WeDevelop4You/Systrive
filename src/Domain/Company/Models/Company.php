<?php

namespace Domain\Company\Models;

use Domain\Cms\Models\Cms;
use Domain\Company\Casts\CompanyModulesCast;
use Domain\Company\Collections\CompanyCollections;
use Domain\Company\Enums\CompanyModuleTypes;
use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Mappings\CompanyTableMap;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\QueryBuilders\CompanyQueryBuilders;
use Domain\Company\Scopes\CompanySoftDeletingScope;
use Domain\Company\Scopes\CompanyViewScope;
use Domain\Invite\Models\Invite;
use Domain\Role\Models\Role;
use Domain\System\Models\System;
use Domain\User\Collections\UserCollection;
use Domain\User\Mappings\UserTableMap;
use Domain\User\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

/**
 * Domain\Company\Models\Company
 *
 * @property int                            $id
 * @property string                         $name
 * @property string                         $slug
 * @property string|null                    $email
 * @property string|null                    $domain
 * @property CompanyStatusTypes             $status
 * @property \Illuminate\Support\Collection $modules
 * @property AsCollection|null              $preferences
 * @property Carbon|null                    $created_at
 * @property Carbon|null                    $updated_at
 * @property Carbon|null                    $deleted_at
 * @property-read Collection<int, Cms> $cms
 * @property-read Collection<int, \Domain\Company\Models\CompanyUser> $companyUser
 * @property-read Collection<int, Invite> $invites
 * @property-read User|null $owner
 * @property-read Collection<int, Role> $roles
 * @property-read System|null $system
 * @property-read System|null $systems
 * @property-read UserCollection<int, User> $users
 *
 * @method static CompanyCollections<int,      static> all($columns = ['*'])
 * @method static CompanyCollections<int,      static> get($columns = ['*'])
 * @method static CompanyQueryBuilders|Company newModelQuery()
 * @method static CompanyQueryBuilders|Company newQuery()
 * @method static Builder|Company              onlyTrashed()
 * @method static CompanyQueryBuilders|Company query()
 * @method static CompanyQueryBuilders|Company whereCreatedAt($value)
 * @method static CompanyQueryBuilders|Company whereDeletedAt($value)
 * @method static CompanyQueryBuilders|Company whereDomain($value)
 * @method static CompanyQueryBuilders|Company whereEmail($value)
 * @method static CompanyQueryBuilders|Company whereId($value)
 * @method static CompanyQueryBuilders|Company whereModules($value)
 * @method static CompanyQueryBuilders|Company whereName($value)
 * @method static CompanyQueryBuilders|Company wherePreferences($value)
 * @method static CompanyQueryBuilders|Company whereSlug($value)
 * @method static CompanyQueryBuilders|Company whereStatus($value)
 * @method static CompanyQueryBuilders|Company whereUpdatedAt($value)
 * @method static Builder|Company              withTrashed()
 * @method static Builder|Company              withoutTrashed()
 *
 * @mixin Eloquent
 */
class Company extends Model
{
    use Prunable;
    use SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        CompanyTableMap::COL_NAME,
        CompanyTableMap::COL_EMAIL,
        CompanyTableMap::COL_DOMAIN,
        CompanyTableMap::COL_STATUS,
        CompanyTableMap::COL_MODULES,
        CompanyTableMap::COL_PREFERENCES,
    ];

    protected $casts = [
        CompanyTableMap::COL_STATUS => CompanyStatusTypes::class,
        CompanyTableMap::COL_MODULES => CompanyModulesCast::class,
        CompanyTableMap::COL_PREFERENCES => AsCollection::class,
    ];

    /**
     * @return Builder|Company
     */
    public function prunable(): Company|Builder
    {
        return static::withoutGlobalScope(CompanyViewScope::class)
            ->whereDate(CompanyTableMap::COL_DELETED_AT, '<', Carbon::now()->subDays(31));
    }

    /**
     * @param CompanyModuleTypes $type
     * @param bool               $excludeSuperAdmin
     *
     * @return bool
     */
    public function hasModule(CompanyModuleTypes $type, bool $excludeSuperAdmin = false): bool
    {
        if (!$excludeSuperAdmin && Auth::user()->isSuperAdmin()) {
            return true;
        }

        return $this->modules->get($type->value, false);
    }

    /**
     * @param bool $excludeSuperAdmin
     *
     * @return bool
     */
    public function hasCMSModule(bool $excludeSuperAdmin = false): bool
    {
        return $this->hasModule(
            CompanyModuleTypes::CMS,
            $excludeSuperAdmin
        );
    }

    /**
     * @param bool $excludeSuperAdmin
     *
     * @return bool
     */
    public function hasSystemModule(bool $excludeSuperAdmin = false): bool
    {
        return $this->hasModule(
            CompanyModuleTypes::SYSTEM,
            $excludeSuperAdmin
        );
    }

    /**
     * @param User $user
     *
     * @return HasOneThrough
     */
    public function user(User $user): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            CompanyUser::class,
            secondKey: UserTableMap::COL_ID,
            secondLocalKey: CompanyUserTableMap::COL_USER_ID
        )->where(UserTableMap::COL_ID, $user->id)->withTrashed();
    }

    /**
     * @return HasOneThrough
     */
    public function owner(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            CompanyUser::class,
            secondKey: UserTableMap::COL_ID,
            secondLocalKey: CompanyUserTableMap::COL_USER_ID
        )->where(CompanyUserTableMap::TABLE_IS_OWNER, true)->withTrashed();
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(CompanyUser::class)
            ->withPivot(
                CompanyUserTableMap::COL_STATUS,
                CompanyUserTableMap::COL_IS_OWNER
            );
    }

    /**
     * @return HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /**
     * @return HasMany
     */
    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * @return HasMany
     */
    public function companyUser(): HasMany
    {
        return $this->hasMany(CompanyUser::class);
    }

    /**
     * @return HasOne
     */
    public function system(): HasOne
    {
        return $this->hasOne(System::class);
    }

    /**
     * @return HasOne
     *
     * @deprecated Use system instead
     */
    public function systems(): hasOne
    {
        return $this->system();
    }

    /**
     * @return HasMany
     */
    public function cms(): HasMany
    {
        return $this->hasMany(Cms::class);
    }

    /**
     * @param User $user
     * @param bool $value
     *
     * @return int
     */
    public function updateOwnership(User $user, bool $value): int
    {
        return $this->users()->updateExistingPivot($user->id, [
            CompanyUserTableMap::COL_IS_OWNER => $value,
        ]);
    }

    /**
     * @param User $user
     *
     * @return int
     */
    public function giveOwnership(User $user): int
    {
        return $this->updateOwnership($user, true);
    }

    /**
     * @param User $user
     *
     * @return int
     */
    public function removeOwnership(User $user): int
    {
        return $this->updateOwnership($user, false);
    }

    /**
     * @param $query
     *
     * @return CompanyQueryBuilders
     */
    public function newEloquentBuilder($query): CompanyQueryBuilders
    {
        return new CompanyQueryBuilders($query);
    }

    /**
     * @param array $models
     *
     * @return CompanyCollections
     */
    public function newCollection(array $models = []): CompanyCollections
    {
        return new CompanyCollections($models);
    }

    /**
     * @return Stringable
     */
    public function storagePath(): Stringable
    {
        return Str::of('companies/')
            ->append(md5($this->id));
    }

    /**
     * @return void
     */
    protected static function booted(): void
    {
        self::addGlobalScope(new CompanyViewScope());
    }

    /**
     * @return void
     */
    public static function bootSoftDeletes(): void
    {
        self::addGlobalScope(new CompanySoftDeletingScope());
    }
}
