<?php

    namespace Domain\User\Actions;

    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\SecurityHelper;

    class EnableUserAccountSecurityAction
    {
        public function __invoke(int $oneTimePassword): void
        {
            $security = Auth::user()->security;
            $security->enabled = true;

            SecurityHelper::create($security)->setRecoveryCodes();
        }
    }
