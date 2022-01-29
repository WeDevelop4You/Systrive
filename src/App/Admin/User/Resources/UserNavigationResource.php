<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserNavigationResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'avatar' => $this->createAvatar(),
                'route' => [
                    'name' => 'company.dashboard',
                    'params' => ['companyName' => $this->name],
                ],
            ];
        }

        /**
         * @return string
         */
        private function createAvatar(): string
        {
            return "https://avatar.oxro.io/avatar.svg?name={$this->name}&rounded=250&caps=1";
        }
    }
