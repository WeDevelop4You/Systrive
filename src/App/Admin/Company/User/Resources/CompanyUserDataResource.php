<?php

    namespace App\Admin\Company\User\Resources;

    use Domain\User\Models\UserInvite;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Support\Helpers\Vuetify;

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
                'profile' => [
                    'full_name' => $this->full_name,
                ],
                'isOwner' => $this->id === $request->company->owner_id,
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
                UserInvite::INVITE_USER_REQUESTED => Vuetify::COLOR_INFO,
                UserInvite::INVITE_USER_ACCEPTED => Vuetify::COLOR_SUCCESS,
            };

            return $data;
        }
    }
