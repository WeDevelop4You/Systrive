<?php

namespace Domain\User\Actions;

use Domain\User\DataTransferObjects\UserProfileData;
use Domain\User\Enums\UserPreferences;
use Domain\User\Models\User;
use Domain\User\Models\UserProfile;
use Illuminate\Support\Collection;

class UpdateUserProfileAction
{
    public function __construct(
        public User $user
    ) {
        //
    }

    public function __invoke(UserProfileData $userProfileData): void
    {
        /** @var UserProfile $userProfile */
        $userProfile = $this->user->profile()->firstOrNew();
        $userProfile->first_name = $userProfileData->first_name;
        $userProfile->middle_name = $userProfileData->middle_name;
        $userProfile->last_name = $userProfileData->last_name;
        $userProfile->gender = $userProfileData->gender;
        $userProfile->birth_date = $userProfileData->birth_date;

        if (!$userProfile->exists) {
            $userProfile->preferences = Collection::make([
                UserPreferences::DARK_MODE->value => true,
            ]);
        }

        $userProfile->save();
    }
}
