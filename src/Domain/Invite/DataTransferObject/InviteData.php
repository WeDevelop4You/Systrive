<?php

namespace Domain\Invite\DataTransferObject;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class InviteData
{
    /**
     * InviteData constructor.
     *
     * @param int         $companyId
     * @param string      $token
     * @param string|null $encryptEmail
     */
    public function __construct(
            public int $companyId,
            public string $token,
            public ?string $encryptEmail = null
        ) {
            //
    }

    /**
     * @return string
     */
    public function decryptEmail(): string
    {
        if (\is_null($this->encryptEmail)) {
            return Auth::user()->email;
        }

        return Crypt::decryptString($this->encryptEmail);
    }

    public function export(): array
    {
        return get_object_vars($this);
    }
}
