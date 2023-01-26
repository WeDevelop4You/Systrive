<?php

namespace Domain\User\Models;

use Domain\User\Mappings\UserSecurityTableMap;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Support\Casts\EncryptionCast;

/**
 * Domain\User\Models\UserSecurity
 *
 * @property int                             $user_id
 * @property \Support\Utils\Decrypt          $secret_key
 * @property \Support\Utils\Decrypt|null     $recovery_codes
 * @property bool                            $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSecurity whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserSecurity extends Model
{
    protected $table = 'user_security';

    protected $primaryKey = UserSecurityTableMap::COL_USER_ID;

    protected $fillable = [
        UserSecurityTableMap::COL_ENABLED,
        UserSecurityTableMap::COL_SECRET_KEY,
        UserSecurityTableMap::COL_RECOVERY_CODES,
    ];

    protected $casts = [
        UserSecurityTableMap::COL_ENABLED => 'boolean',
        UserSecurityTableMap::COL_SECRET_KEY => EncryptionCast::class,
        UserSecurityTableMap::COL_RECOVERY_CODES => EncryptionCast::class.':true',
    ];

    /**
     * @param string $code
     *
     * @return bool
     */
    public function verifyOneTimePassword(string $code): bool
    {
        try {
            $provider = new Google2FA();

            return (bool) $provider->verifyKey($this->secret_key->decrypt, $code);
        } catch (IncompatibleWithGoogleAuthenticatorException|InvalidCharactersException|SecretKeyTooShortException|DecryptException) {
            return false;
        }
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function verifyRecoveryCode(string $code): bool
    {
        try {
            $recoveryCodes = $this->recovery_codes->decrypt;

            if (\in_array($code, $recoveryCodes)) {
                $recoveryCodes = array_replace($recoveryCodes, array_fill_keys(
                    array_keys($recoveryCodes, $code),
                    $this->generateRecoveryCode()
                ));

                $this->recovery_codes = $recoveryCodes;
                $this->save();

                return true;
            }
        } catch (DecryptException) {
        }

        return false;
    }

    /**
     * @return string
     */
    public function generateRecoveryCode(): string
    {
        return Str::random(10).'-'.Str::random(10);
    }
}
