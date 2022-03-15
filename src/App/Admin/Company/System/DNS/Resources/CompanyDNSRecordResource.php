<?php

    namespace App\Admin\Company\System\DNS\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Str;

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
                'suspended' => $this->isActive(),
                'created_at' => "{$this->DATE} {$this->TIME}",
            ];
        }

        /**
         * @return array
         */
        private function isActive(): array
        {
            if ($this->SUSPENDED === 'no') {
                return [
                    'is_active' => true,
                    'content' => trans('word.active.active'),
                ];
            }

            return  [
                'is_active' => false,
                'content' => trans('word.inactive.inactive'),
            ];
        }
    }
