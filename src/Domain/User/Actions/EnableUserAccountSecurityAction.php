<?php

    namespace Domain\User\Actions;

    use Domain\User\Models\UserSecurity;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;

    class EnableUserAccountSecurityAction
    {
        public function __invoke(): void
        {
            /** @var UserSecurity $security */
            $security = Auth::user()->security()->firstOrFail();

            $security->enabled = true;
            $security->recovery_codes = Collection::times(
                8,
                fn () => $security->generateRecoveryCode()
            )->toArray();

            $security->save();
        }
    }
