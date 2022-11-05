<?php

namespace App\Admin\Account\Controllers;

use Domain\User\Models\UserSecurity;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AccountRecoveryCodeController
{
    /**
     * @return StreamedResponse
     */
    public function action(): StreamedResponse
    {
        $security = Auth::user()->security;

        if ($security instanceof UserSecurity) {
            $appName = config('app.name');

            return response()->streamDownload(
                function () use ($security) {
                    echo implode("\n", $security->recovery_codes->decrypt());
                },
                "{$appName} Recovery Code.txt",
                ['Content-Type' => 'text/plain']
            );
        }
    }
}
