<?php

    namespace App\Company\System\Domain\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Collection;

    class SystemDomainResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'name' => $this->NAME,
                'template' => strtolower($this->TPL),
                'aliases' => $this->aliases(),
            ];
        }

        /**
         * @return array
         */
        private function aliases(): array
        {
            return Collection::make(explode(',', $this->ALIAS))->map(function (string $alias) {
                return ['value' => $alias];
            })->toArray();
        }
    }
