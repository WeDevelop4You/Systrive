<?php

    namespace App\Admin\Company\Resources;

    use Domain\Company\Mappings\CompanyTableMap;
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
                'resend' => $this->status === CompanyTableMap::EXPIRED_STATUS,
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
            $data['text'] = translateToVuetify("word.{$this->status}.{$this->status}");

            $data['color'] = match ($this->status) {
                CompanyTableMap::INVITED_STATUS => VuetifyColors::INFO,
                CompanyTableMap::EXPIRED_STATUS => VuetifyColors::WARNING,
                CompanyTableMap::COMPLETED_STATUS => VuetifyColors::SUCCESS,
            };

            return $data;
        }
    }
