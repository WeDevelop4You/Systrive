<?php

    namespace App\Admin\Company\Resources;

    use Domain\System\Models\SystemUserDatabase;
    use Domain\System\Models\SystemUserDNS;
    use Domain\System\Models\SystemUserDomain;
    use Domain\System\Models\SystemUserMailDomain;
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
            return $this->domains->map(function (SystemUserDomain $domain) {
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
            return $this->dns->map(function (SystemUserDNS $dns) {
                return [
                    'id' => $dns->id,
                    'name' => $dns->domain,
                    'route' => [
                        'name' => 'company.dns',
                        'params' => ['domainNameServer' => $dns->domain],
                    ],
                ];
            })->toArray();
        }

        private function databases(): array
        {
            return $this->databases->map(function (SystemUserDatabase $database) {
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
            return $this->mailDomains->map(function (SystemUserMailDomain $mailDomains) {
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
