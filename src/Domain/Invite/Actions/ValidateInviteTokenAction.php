<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\states\CompanyInvitedState;
    use Domain\Company\states\CompanyUserRequestedState;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Models\Invite;
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
            $invite = Invite::whereCompanyId($inviteData->companyId)
                ->whereUserByEmail($inviteData->decryptEmail())
                ->first();

            if (!$invite->isExpired() && Hash::check($inviteData->token, $invite->token)) {
                return $invite;
            }

            $invite->type->getStatus($invite)
                ->changeStateWhen(CompanyInvitedState::class, CompanyUserRequestedState::class);

            throw new InvalidTokenException();
        }
    }
