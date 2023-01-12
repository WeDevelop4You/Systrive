<?php

    namespace App\Account\User\Resources;

    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Collection;

    class PreferenceResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            /** @var User $user */
            $user = $this;

            if ($user->profile instanceof UserProfile) {
                /** @var Collection $preferences */
                $preferences = $user->profile->preferences ?? Collection::make();

                $preferences->put('locale', $user->locale);
                $preferences->put('is_secured', (bool) $user->security?->enabled);

                return $preferences->toArray();
            }

            return [];
        }
    }
