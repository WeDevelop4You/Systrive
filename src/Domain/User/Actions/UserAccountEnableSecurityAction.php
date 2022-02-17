<?php

    namespace Domain\User\Actions;

    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\SecurityHelper;

    class UserAccountEnableSecurityAction
    {
        public function __invoke(int $oneTimePassword)
        {
            $security = Auth::user()->security;
            $security->enabled = true;

            SecurityHelper::create($security)->setRecoveryCodes();
        }
    }
