<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;
use Support\Helpers\DecryptHelper;

class EncryptionCast implements CastsAttributes
{
    public function __construct(
        private readonly bool $isArray = false
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes): DecryptHelper
    {
        return new DecryptHelper($value);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        if ($value instanceof DecryptHelper) {
            return $value->getEncrypt();
        }

        return $this->isArray ? Crypt::encrypt($value) : Crypt::encryptString($value);
    }
}
