<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\states\CompanyInvitedState;
    use Domain\Company\states\CompanyUserRequestedState;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Exceptions\InvalidTokenException;
    use Domain\Invite\Models\Invite;
    use Illuminate\Support\Facades\Hash;

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
            $invite = Invite::whereCompanyId($inviteData->companyId)
                ->whereUserByEmail($inviteData->decryptEmail())
                ->first();

            if ($invite instanceof Invite) {
                if (!$invite->isExpired() && Hash::check($inviteData->token, $invite->token)) {
                    return $invite;
                }

                $invite->state()->changeStateWhen(CompanyInvitedState::class, CompanyUserRequestedState::class);
            }

            throw new InvalidTokenException();
        }
    }
