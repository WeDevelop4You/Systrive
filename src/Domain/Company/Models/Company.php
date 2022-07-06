<?php

    namespace Domain\Company\Models;

    use Domain\Company\Collections\CompanyCollections;
    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Observers\CompanyDeletedObserver;
    use Domain\Company\Observers\CompanySavingObserver;
    use Domain\Company\QueryBuilders\CompanyQueryBuilders;
    use Domain\Invite\Models\Invite;
    use Domain\Role\Models\Role;
    use Domain\System\Models\System;
    use Domain\User\Collections\UserCollections;
    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Eloquent;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Database\Eloquent\Relations\HasOneThrough;
    use Illuminate\Support\Carbon;
    use Support\Traits\Observers;

    /**
     * Domain\Company\Models\Company.
     *
     * @property int                $id
     * @property string             $name
     * @property string             $slug
     * @property string|null        $email
     * @property string|null        $domain
     * @property string|null        $information
     * @property CompanyStatusTypes $status
     * @property Carbon|null        $created_at
     * @property Carbon|null        $updated_at
     * @property-read Collection|\Domain\Company\Models\CompanyUser[] $companyUser
     * @property-read Collection|Invite[] $invites
     * @property-read User|null $owner
     * @property-read Collection|Role[] $roles
     * @property-read System|null $system
     * @property-read System|null $systems
     * @property-read User[]|UserCollections $users
     * @property-read User[]|UserCollections $whereOwner
     *
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
     * @method static CompanyQueryBuilders|Company whereSlug($value)
     * @method static CompanyQueryBuilders|Company whereStatus($value)
     * @method static CompanyQueryBuilders|Company whereUpdatedAt($value)
     * @method static CompanyQueryBuilders|Company whereUser(\Domain\User\Models\User $user)
     * @mixin Eloquent
     */
    class Company extends Model
    {
        use Observers;

        protected $table = 'companies';

        protected $fillable = [
            CompanyTableMap::NAME,
            CompanyTableMap::EMAIL,
            CompanyTableMap::DOMAIN,
            CompanyTableMap::INFORMATION,
            CompanyTableMap::STATUS,
        ];

        protected $casts = [
            CompanyTableMap::STATUS => CompanyStatusTypes::class,
        ];

        protected array $observers = [
            CompanySavingObserver::class,
            CompanyDeletedObserver::class,
        ];

        /**
         * @return BelongsToMany
         */
        public function users(): BelongsToMany
        {
            return $this->belongsToMany(User::class)
                ->using(CompanyUser::class)
                ->withPivot(
                    CompanyUserTableMap::STATUS,
                    CompanyUserTableMap::IS_OWNER
                );
        }

        /**
         * @return HasOneThrough
         */
        public function owner(): HasOneThrough
        {
            return $this->hasOneThrough(
                User::class,
                CompanyUser::class,
                secondKey: UserTableMap::ID,
                secondLocalKey: CompanyUserTableMap::USER_ID
            )->where(CompanyUserTableMap::TABLE_IS_OWNER, true)->withTrashed();
        }

        /**
         * @return BelongsToMany
         */
        public function whereOwner(): BelongsToMany
        {
            return $this->users()->wherePivot(CompanyUserTableMap::IS_OWNER, true)->withTrashed();
        }

        /**
         * @param string $email
         *
         * @return BelongsToMany
         */
        public function whereUserByEmail(string $email): BelongsToMany
        {
            return $this->users()->where(UserTableMap::EMAIL, $email);
        }

        /**
         * @param User $user
         * @param bool $value
         *
         * @return int
         */
        public function updateOwnership(User $user, bool $value = false): int
        {
            return $this->users()->updateExistingPivot($user->id, [
                CompanyUserTableMap::IS_OWNER => $value,
            ]);
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
    }
