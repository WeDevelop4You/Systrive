<?php

    namespace App\Admin\Company\Resources;

    use App\Admin\User\Resources\UserListResource;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyEditResource extends JsonResource
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
                'email' => $this->email,
                'domain' => $this->domain,
                'information' => $this->information,
                'owner' => UserListResource::make($this->whereOwner()->first()),
            ];
        }
    }