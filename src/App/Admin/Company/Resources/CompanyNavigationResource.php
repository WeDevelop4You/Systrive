<?php

    namespace App\Admin\Company\Resources;

    use Domain\System\Models\SystemDatabase;
    use Domain\System\Models\SystemDNS;
    use Domain\System\Models\SystemDomain;
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
            $hasData = !is_null($this->resource);

            return [
                'name' => $request->company->name,
                'domains' => $hasData ? $this->domains() : [],
                'dns' => $hasData ? $this->dns() : [],
                'databases' => $hasData ? $this->databases() : [],
                'mail_domains' => $hasData ? $this->mailDomains() : [],
            ];
        }

        /**
         * @return array
         */
        private function domains(): array
        {
            return $this->domains->map(function (SystemDomain $domain) {
                return [
                     'id' => $domain->id,
                     'name' => $domain->name,
                     'route' => [
                         'name' => 'company.domain',
                         'params' => ['domainName' => $domain->name],
                     ],
                 ];
            })->toArray();
        }

        private function dns(): array
        {
            dd($this->dns);

            return $this->dns->map(function (SystemDNS $dns) {
                return [
                    'id' => $dns->id,
                    'name' => $dns->name,
                    'route' => [
                        'name' => 'company.dns',
                        'params' => ['domainNameServer' => $dns->name],
                    ],
                ];
            })->toArray();
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
