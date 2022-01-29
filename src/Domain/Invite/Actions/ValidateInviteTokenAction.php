<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Hash;
    use Support\Exceptions\InvalidTokenException;

    class ValidateInviteTokenAction
    {
        /**
         * @param InviteData $inviteData
         *
         * @throws InvalidTokenException
         *
         * @return Invite
         */
        public function __invoke(InviteData $inviteData): Invite
        {
            $invite = Invite::where('company_id', $inviteData->companyId)
                ->where('email', $inviteData->decryptEmail())
                ->firstOrFail();

            if ($this->validateToken($invite->created_at, $inviteData->token, $invite->token)) {
                return $invite;
            }

            switch ($invite->type) {
                case InviteTableMap::USER_TYPE:
                    $oldStatus = CompanyUserTableMap::REQUESTED_STATUS;
                    $newStatus = CompanyUserTableMap::EXPIRED_STATUS;

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    $oldStatus = CompanyTableMap::INVITED_STATUS;
                    $newStatus = CompanyTableMap::EXPIRED_STATUS;

                    break;
                default:
                    throw new InvalidTokenException();
            }

            (new ChangeInviteStatusAction($oldStatus, $newStatus))($invite);

            throw new InvalidTokenException();
        }

        /**
         * @param string $created_at
         * @param string $token
         * @param string $hashToken
         *
         * @return bool
         */
        private function validateToken(string $created_at, string $token, string $hashToken): bool
        {
            return !$this->tokenExpired($created_at) && Hash::check($token, $hashToken);
        }

        /**
         * Determine if the token has expired.
         *
         * @param string $createdAt
         *
         * @return bool
         */
        private function tokenExpired(string $createdAt): bool
        {
            return Carbon::parse($createdAt)->addDays(7)->isPast();
        }
    }
