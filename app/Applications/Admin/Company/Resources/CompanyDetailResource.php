<?php

    namespace App\Admin\Company\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyDetailResource extends JsonResource
    {
        /**
         * @param Request $request
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'avatar' => $this->createAvatar(),
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
