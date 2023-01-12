<?php

    namespace App\Company\User\Requests;

    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Support\Abstracts\AbstractRequest;
    use Support\Rules\UniquePivotRule;

    /**
     * @property Company $company
     */
    class UserRequest extends AbstractRequest
    {
        protected function defaultRules(): array
        {
            return [
                'roles' => ['present', 'array'],
                'roles.*' => ['exists:roles,id'],
                'permissions' => ['present', 'array'],
                'permissions.*' => ['exists:permissions,id'],
            ];
        }

        protected function storeRules(): array
        {
            $unique = new UniquePivotRule(
                User::withTrashed(),
                $this->company->users(),
                CompanyUserTableMap::TABLE_USER_ID
            );

            return [
                'email' => ['required', 'email', $unique],
            ];
        }

        protected function updateRules(): array
        {
            return [];
        }
    }
