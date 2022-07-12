<?php

    namespace App\Admin\Company\Resources;

    use Domain\System\Models\SystemDatabase;
    use Domain\System\Models\SystemMailDomain;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Str;

    class CompanyNavigationResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            $hasData = !\is_null($this->resource);

            return [
                'name' => $request->company->name,
                'dns' => $hasData ? $this->dns() : [],
                'databases' => $hasData ? $this->databases() : [],
                'mail_domains' => $hasData ? $this->mailDomains() : [],
            ];
        }

        private function databases(): array
        {
            return $this->databases->map(function (SystemDatabase $database) {
                return [
                    'id' => $database->id,
                    'name' => Str::after($database->name, "{$this->name}_"),
                    'route' => [
                        'name' => 'company.database',
                        'params' => ['databaseName' => $database->name],
                    ],
                ];
            })->toArray();
        }

        private function mailDomains(): array
        {
            return $this->mailDomains->map(function (SystemMailDomain $mailDomains) {
                return [
                    'id' => $mailDomains->id,
                    'name' => $mailDomains->name,
                    'route' => [
                        'name' => 'company.mail',
                        'params' => ['mailDomainName' => $mailDomains->name],
                    ],
                ];
            })->toArray();
        }
    }
