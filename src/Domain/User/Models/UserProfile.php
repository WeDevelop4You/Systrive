<?php

namespace Domain\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\User\Models\UserProfile.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property string                          $first_name
 * @property string|null                     $middle_name
 * @property string                          $last_name
 * @property string                          $gender
 * @property mixed                           $birth_date
 * @property string|null                     $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 *
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
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'bio',
    ];

    protected $casts = [
        'birth_date' => 'date:Y-m-d',
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ($this->middle_name ? " $this->middle_name " : ' ') . $this->last_name;
    }
}
