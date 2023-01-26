<?php

namespace Domain\User\Models;

use Domain\User\Mappings\UserProfileTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Domain\User\Models\UserProfile
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $first_name
 * @property string|null $middle_name
 * @property string      $last_name
 * @property string      $gender
 * @property Carbon      $birth_date
 * @property mixed|null  $preferences
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read \Domain\User\Models\User $user
 *
 * @method static Builder|UserProfile newModelQuery()
 * @method static Builder|UserProfile newQuery()
 * @method static Builder|UserProfile query()
 * @method static Builder|UserProfile whereBirthDate($value)
 * @method static Builder|UserProfile whereCreatedAt($value)
 * @method static Builder|UserProfile whereFirstName($value)
 * @method static Builder|UserProfile whereGender($value)
 * @method static Builder|UserProfile whereId($value)
 * @method static Builder|UserProfile whereLastName($value)
 * @method static Builder|UserProfile whereMiddleName($value)
 * @method static Builder|UserProfile wherePreferences($value)
 * @method static Builder|UserProfile whereUpdatedAt($value)
 * @method static Builder|UserProfile whereUserId($value)
 *
 * @mixin Eloquent
 */
class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        UserProfileTableMap::COL_FIRST_NAME,
        UserProfileTableMap::COL_MIDDLE_NAME,
        UserProfileTableMap::COL_LAST_NAME,
        UserProfileTableMap::COL_GENDER,
        UserProfileTableMap::COL_BIRTH_DATE,
        UserProfileTableMap::COL_PREFERENCES,
    ];

    protected $casts = [
        UserProfileTableMap::COL_BIRTH_DATE => 'date:Y-m-d',
        UserProfileTableMap::COL_PREFERENCES => AsCollection::class,
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.($this->middle_name ? " $this->middle_name " : ' ').$this->last_name;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
