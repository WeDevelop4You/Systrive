<?php

    namespace App\Admin\Company\Resources;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Support\Enums\Vuetify\VuetifyColors;

    class CompanyDataResource extends JsonResource
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
                'status' => $this->getStatus(),
                'resend' => $this->status === CompanyStatusTypes::EXPIRED,
                'created_at' => $this->created_at->toDatetimeString(),
                'owner' => [
                    'full_name' => $this->whereOwner()->first()?->full_name,
                ],
            ];
        }

        /**
         * @return array
         */
        private function getStatus(): array
        {
            $data['text'] = $this->status->getTranslation();

            $data['color'] = match ($this->status) {
                CompanyStatusTypes::INVITED => VuetifyColors::INFO,
                CompanyStatusTypes::EXPIRED => VuetifyColors::WARNING,
                CompanyStatusTypes::COMPLETED => VuetifyColors::SUCCESS,
            };

            return $data;
        }
    }
