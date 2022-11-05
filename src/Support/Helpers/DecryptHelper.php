<?php

namespace Support\Helpers;

use Illuminate\Support\Facades\Crypt;

class DecryptHelper
{
    public function __construct(
        private readonly ?string $encrypt,
    ) {
        //
    }

    /**
     * @return mixed
     */
    public function decrypt(): mixed
    {
        return \is_null($this->encrypt) ? null : Crypt::decrypt($this->encrypt);
    }

    /**
     * @return string|null
     */
    public function decryptString(): ?string
    {
        return \is_null($this->encrypt) ? null : Crypt::decryptString($this->encrypt);
    }

    /**
     * @return string|null
     */
    public function getEncrypt(): ?string
    {
        return $this->encrypt;
    }
}
