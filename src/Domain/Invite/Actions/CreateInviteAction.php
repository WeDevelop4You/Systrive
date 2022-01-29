<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\Models\Company;
    use Domain\Invite\Models\Invite;
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
         * @param string  $email
         * @param string  $type
         * @param Company $company
         */
        public function __construct(
            private string $email,
            private string $type,
            private Company $company,
        ) {
            $this->token = TokenGeneratorHelper::create();

            Invite::whereInviteByEmailAndCompany($email, $company->id, $this->type)->delete();
        }

        /**
         * @return string
         */
        public function __invoke(): string
        {
            $invite = new Invite();
            $invite->type = $this->type;
            $invite->email = $this->email;
            $invite->token = $this->token->getHashToken();
            $invite->company_id = $this->company->id;
            $invite->save();

            return $this->token->getToken();
        }
    }
