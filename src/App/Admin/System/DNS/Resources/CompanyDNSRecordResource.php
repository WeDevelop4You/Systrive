<?php

    namespace App\Admin\System\DNS\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Str;
    use Support\Helpers\Vesta\VestaHelper;

    class CompanyDNSRecordResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->ID,
                'record' => $this->RECORD,
                'type' => $this->TYPE,
                'value' => Str::limit($this->VALUE, 50),
                'suspended' => VestaHelper::isActive($this->SUSPENDED, true),
                'created_at' => "{$this->DATE} {$this->TIME}",
            ];
        }
    }
