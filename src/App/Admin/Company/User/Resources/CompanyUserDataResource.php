<?php

    namespace App\Admin\Company\User\Resources;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Support\Enums\Vuetify\VuetifyColors;

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
                'resend' => $this->pivot->status == CompanyUserStatusTypes::EXPIRED,
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

            $data['text'] = $status->getTranslation();

            $data['color'] = match ($status) {
                CompanyUserStatusTypes::REQUESTED => VuetifyColors::INFO,
                CompanyUserStatusTypes::EXPIRED => VuetifyColors::WARNING,
                CompanyUserStatusTypes::ACCEPTED => VuetifyColors::SUCCESS,
            };

            return $data;
        }
    }
