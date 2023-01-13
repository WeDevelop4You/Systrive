<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;
use Support\Utils\Decrypt;

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
    public function get($model, string $key, $value, array $attributes): Decrypt
    {
        return new Decrypt($value, $this->isArray);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        if ($value instanceof Decrypt) {
            return $value->encrypt;
        }

        return Crypt::encrypt($value, $this->isArray);
    }
}
