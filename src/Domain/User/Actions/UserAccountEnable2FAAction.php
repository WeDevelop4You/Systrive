<?php

    namespace Domain\User\Actions;

    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;

    class UserAccountEnable2FAAction
    {
        public function __invoke(int $oneTimePassword)
        {
            $recoveryCodes = Collection::times(8, function() {
                return Str::random(10).'-'.Str::random(10);
            })->toArray();

            $security = Auth::user()->security;
            $security->recovery_keys = Crypt::encrypt($recoveryCodes);
            $security->enabled = true;
            $security->save();
        }
    }
