<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserListResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            $text = $this->email;

            if (!\is_null($this->full_name)) {
                $text .= ", ({$this->full_name})";
            }

            return [
                'value' => $this->email,
                'text' => $text,
            ];
        }
    }
