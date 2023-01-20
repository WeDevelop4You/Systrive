<?php

namespace Support\Utils;

use Illuminate\Support\Facades\Crypt;

class Decrypt
{
    public readonly mixed $decrypt;

    public function __construct(
        public readonly ?string $encrypt,
        bool $isArray = false,
    ) {
        $this->decrypt = Crypt::decrypt($this->encrypt, $isArray);
    }
}
