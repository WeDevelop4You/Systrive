<?php

namespace Support\Helpers;

use Illuminate\Support\Facades\Crypt;

class DecryptHelper
{
    public readonly mixed $decrypt;

    public function __construct(
        public readonly ?string $encrypt,
        bool $isArray = false,
    ) {
        $this->decrypt = Crypt::decrypt($this->encrypt, $isArray);
    }
}
