<?php

namespace Domain\Git\Actions;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Domain\Git\Models\GitAccount;
use Domain\Git\Models\GitAccountAccessTokens;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\User;

class CreateOrUpdateGitAccountAction
{
    public function __construct(
        private GitServiceTypes $service
    ) {
        //
    }

    public function __invoke(User $serviceUser)
    {
        /** @var GitAccount $gitAccount */
        $gitAccount = Auth::user()
            ->gitAccounts()
            ->where(GitAccountTableMap::COL_SERVICE, $this->service)
            ->firstOrNew();

        $gitAccount->service = $this->service;
        $gitAccount->username = $serviceUser->nickname;
        $gitAccount->save();

        /** @var GitAccountAccessTokens $accessToken */
        $accessToken = $gitAccount->accessToken()->firstOrNew();

        $accessToken->token = $serviceUser->token;
        $accessToken->expires_in = $serviceUser->expiresIn;
        $accessToken->refresh_token = $serviceUser->refreshToken;
        $accessToken->save();
    }
}
