<?php

    namespace App\Admin\Company\User\Resources;

    use Domain\Company\Mappings\CompanyUserTableMap;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Support\Enums\Vuetify\VuetifyColors;
    use Support\Helpers\VuetifyHelper;

    class CompanyUserDataResource extends JsonResource
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
                'email' => $this->email,
                'status' => $this->getStatus(),
                'resend' => $this->pivot->status === CompanyUserTableMap::EXPIRED_STATUS,
                'profile' => [
                    'full_name' => $this->full_name,
                ],
                'isOwner' => (bool) $this->pivot->is_owner,
            ];
        }

        /**
         * @return array
         */
        private function getStatus(): array
        {
            $status = $this->pivot->status;

            $data['text'] = translateToVuetify("word.{$status}.{$status}");

            $data['color'] = match ($status) {
                CompanyUserTableMap::REQUESTED_STATUS => VuetifyColors::INFO,
                CompanyUserTableMap::EXPIRED_STATUS => VuetifyColors::WARNING,
                CompanyUserTableMap::ACCEPTED_STATUS => VuetifyColors::SUCCESS,
            };

            return $data;
        }
    }
