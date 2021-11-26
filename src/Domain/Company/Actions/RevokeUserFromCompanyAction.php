<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    class RevokeUserFromCompanyAction
    {
        public function __construct(
            public Company $company,
        ) {
            //
        }

        /**
         * @param User $user
         *
         * @return User
         */
        public function __invoke(User $user): User
        {
            $this->company->users()->detach($user->id);

            (new UserPermissionsForCompanyAction($this->company, $user))(new CompanyUserData([], []));

            if ($user->companies()->doesntExist()) {
                $user->delete();
            }

            return $user;
        }
    }
