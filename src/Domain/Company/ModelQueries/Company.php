<?php

    namespace Domain\Company\ModelQueries;

    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\CompanyUser;
    use Domain\Invite\Models\Invite;
    use Domain\Role\Models\Role;
    use Domain\System\Models\System;
    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    /**
 * Domain\Company\ModelQueries\Company
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $domain
 * @property string|null $information
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Invite[] $invites
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read System|null $system
 * @property-read \Domain\User\Collections\UserCollections|User[] $users
 * @property-read \Domain\User\Collections\UserCollections|User[] $whereOwner
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @mixin \Eloquent
 */
    class Company extends Model
    {
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
        public function whereUserEmail(string $email): BelongsToMany
        {
            return $this->users()->where(UserTableMap::EMAIL, $email);
        }

        /**
         * @param User $user
         * @param bool        $value
         *
         * @return int
         */
        public function updateOwnership(User $user, bool $value = false): int
        {
            return $this->users()->updateExistingPivot($user->id, [CompanyUserTableMap::IS_OWNER => $value]);
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
         * @return HasOne
         */
        public function system(): HasOne
        {
            return $this->hasOne(System::class);
        }
    }
