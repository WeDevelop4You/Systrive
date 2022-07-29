<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\Models\Company;
    use Domain\Invite\Enums\InviteTypes;
    use Domain\Invite\Models\Invite;
    use Domain\User\Models\User;
    use Support\Helpers\TokenGeneratorHelper;

    class CreateInviteAction
    {
        /**
         * @var TokenGeneratorHelper
         */
        private TokenGeneratorHelper $token;

        /**
         * CreateInviteAction constructor.
         *
         * @param User        $user
         * @param Company     $company
         * @param InviteTypes $type
         */
        public function __construct(
            private readonly User $user,
            private readonly Company $company,
            private readonly InviteTypes $type,
        ) {
            $this->token = TokenGeneratorHelper::create();

            Invite::whereInviteByUserAndCompany($user, $company)
                ->whereType($this->type)
                ->delete();
        }

        /**
         * @return string
         */
        public function __invoke(): string
        {
            $invite = new Invite();
            $invite->type = $this->type;
            $invite->user_id = $this->user->id;
            $invite->company_id = $this->company->id;
            $invite->token = $this->token->getHashToken();
            $invite->save();

            return $this->token->getToken();
        }
    }
