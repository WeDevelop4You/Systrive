<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Domain\Company\ModelQueries{
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Invite\Models\Invite[] $invites
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Role\Models\Role[] $roles
 * @property-read \Domain\System\Models\System|null $system
 * @property-read \Domain\User\Collections\UserCollections|\Domain\User\Models\User[] $users
 * @property-read \Domain\User\Collections\UserCollections|\Domain\User\Models\User[] $whereOwner
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
 */
	class Company extends \Eloquent {}
}

namespace Domain\Company\Models{
/**
 * Domain\Company\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $domain
 * @property string|null $information
 * @property \Domain\Company\Enums\CompanyStatusTypes $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Invite\Models\Invite[] $invites
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Role\Models\Role[] $roles
 * @property-read \Domain\System\Models\System|null $system
 * @property-read \Domain\User\Collections\UserCollections|\Domain\User\Models\User[] $users
 * @property-read \Domain\User\Collections\UserCollections|\Domain\User\Models\User[] $whereOwner
 * @method static \Domain\Company\Collections\CompanyCollections|static[] all($columns = ['*'])
 * @method static \Domain\Company\Collections\CompanyCollections|static[] get($columns = ['*'])
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
 */
	class Company extends \Eloquent {}
}

namespace Domain\Company\Models{
/**
 * Domain\Company\Models\CompanyUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property int $is_owner
 * @property \Domain\Company\Enums\CompanyUserStatusTypes|null $status
 * @property-read \Domain\User\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereIsOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereUserId($value)
 */
	class CompanyUser extends \Eloquent {}
}

namespace Domain\Invite\Models{
/**
 * Domain\Invite\Models\Invite
 *
 * @property int|null $company_id
 * @property string $email
 * @property string $token
 * @property string $type
 * @property string $created_at
 * @property-read \Domain\Company\Models\Company|null $company
 * @property-read \Domain\User\Models\User|null $user
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite newModelQuery()
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite newQuery()
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite query()
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereCompanyId($value)
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereCompanyType()
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereCreatedAt($value)
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereEmail($value)
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereExpired()
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereInviteByEmailAndCompany(string $email, int $companyId, ?string $type = null)
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereToken($value)
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereType($value)
 * @method static \Domain\Invite\QueryBuilders\InviteQueryBuilders|Invite whereUserType()
 */
	class Invite extends \Eloquent {}
}

namespace Domain\Role\Models{
/**
 * Domain\Role\Models\Role
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Domain\User\Collections\UserCollections|\Domain\User\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace Domain\System\Models{
/**
 * Domain\System\Models\System
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $username
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\Company\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\System\Models\SystemDatabase[] $databases
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\System\Models\SystemDNS[] $dns
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\System\Models\SystemDomain[] $domains
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\System\Models\SystemMailDomain[] $mailDomains
 * @method static \Illuminate\Database\Eloquent\Builder|System newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|System newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|System query()
 * @method static \Illuminate\Database\Eloquent\Builder|System whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereUsername($value)
 */
	class System extends \Eloquent {}
}

namespace Domain\System\Models{
/**
 * Domain\System\Models\SystemDNS
 *
 * @property int $id
 * @property int $system_id
 * @property string $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDNS whereUpdatedAt($value)
 */
	class SystemDNS extends \Eloquent {}
}

namespace Domain\System\Models{
/**
 * Domain\System\Models\SystemDatabase
 *
 * @property int $id
 * @property int $system_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDatabase whereUpdatedAt($value)
 */
	class SystemDatabase extends \Eloquent {}
}

namespace Domain\System\Models{
/**
 * Domain\System\Models\SystemDomain
 *
 * @property int $id
 * @property int $system_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\System\Models\SystemUsageStatistic[] $usageStatistics
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemDomain whereUpdatedAt($value)
 */
	class SystemDomain extends \Eloquent {}
}

namespace Domain\System\Models{
/**
 * Domain\System\Models\SystemMailDomain
 *
 * @property int $id
 * @property int $system_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemMailDomain whereUpdatedAt($value)
 */
	class SystemMailDomain extends \Eloquent {}
}

namespace Domain\System\Models{
/**
 * Domain\System\Models\SystemUsageStatistic
 *
 * @property string $model_type
 * @property int $model_id
 * @property string $type
 * @property int $total
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $statisticFrom
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemUsageStatistic whereUpdatedAt($value)
 */
	class SystemUsageStatistic extends \Eloquent {}
}

namespace Domain\User\Models{
/**
 * Domain\User\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $locale
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Domain\Company\Collections\CompanyCollections|\Domain\Company\Models\Company[] $companies
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Company\Models\CompanyUser[] $companyUser
 * @property-read string|null $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Domain\User\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Domain\User\Models\UserSecurity|null $security
 * @method static \Domain\User\Collections\UserCollections|static[] all($columns = ['*'])
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Domain\User\Collections\UserCollections|static[] get($columns = ['*'])
 * @method static \Domain\User\Queries\UserQueryBuilders|User newModelQuery()
 * @method static \Domain\User\Queries\UserQueryBuilders|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Domain\User\Queries\UserQueryBuilders|User permission($permissions)
 * @method static \Domain\User\Queries\UserQueryBuilders|User query()
 * @method static \Domain\User\Queries\UserQueryBuilders|User role($roles, $guard = null)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereCreatedAt($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereDeletedAt($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereEmail($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereEmailVerifiedAt($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereId($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereLocale($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User wherePassword($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereRememberToken($value)
 * @method static \Domain\User\Queries\UserQueryBuilders|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace Domain\User\Models{
/**
 * Domain\User\Models\UserProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $gender
 * @property mixed $birth_date
 * @property string|null $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read \Domain\User\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUserId($value)
 */
	class UserProfile extends \Eloquent {}
}

namespace Domain\User\Models{
/**
 * Domain\User\Models\UserSecurity
 *
 * @property int $user_id
 * @property string $secret_key
 * @property string|null $recovery_codes
 * @property int $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUserId($value)
 */
	class UserSecurity extends \Eloquent {}
}

namespace Domain\User\Queries{
/**
 * Domain\User\Queries\UserQueries
 *
 * @property-read \Domain\Company\Collections\CompanyCollections|\Domain\Company\Models\Company[] $companies
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Company\Models\CompanyUser[] $companyUser
 * @property-read string|null $full_name
 * @property-read \Domain\User\Models\UserProfile|null $profile
 * @property-read \Domain\User\Models\UserSecurity|null $security
 * @method static \Illuminate\Database\Eloquent\Builder|UserQueries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserQueries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserQueries query()
 */
	class UserQueries extends \Eloquent {}
}

