<?php

    namespace App\Admin\System\MailDomain\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Support\Helpers\Vesta\VestaHelper;

    class CompanyMailDomainAddressResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'email' => $this->EMAIL,
                'forward_email' => $this->FWD,
                'forward_saved' => VestaHelper::isActive($this->FWD_ONLY),
                'usage' => "{$this->U_DISK} / {$this->QUOTA}",
                'suspended' => VestaHelper::isActive($this->SUSPENDED, true),
                'created_at' => "{$this->DATE} {$this->TIME}",
            ];
        }
    }
