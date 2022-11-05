<?php

    namespace App\Admin\Company\Resources;

    use Domain\Company\Models\Company;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    /**
     * @mixin Company
     */
    class CompanyCreateResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'name' => null,
                'owner' => null,
                'modules' => CompanyModuleResource::make($this->modules),
            ];
        }
    }
