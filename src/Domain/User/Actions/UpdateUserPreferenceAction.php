<?php

namespace Domain\User\Actions;

use Domain\User\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class UpdateUserPreferenceAction
{
    /**
     * @param string $type
     * @param mixed  $value
     *
     * @return void
     */
    public function __invoke(string $type, mixed $value): void
    {
        /** @var UserProfile $profile */
        $profile = Auth::user()->profile()->firstOrNew();
        $profile->preferences->put($type, $value);
        $profile->save();
    }
}
