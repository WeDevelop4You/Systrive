<?php

namespace Domain\User\Jobs;

use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Domain\Invite\Models\Invite;
use Domain\User\Notifications\InviteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Encryption\MissingAppKeyException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Support\Helpers\TokenGeneratorHelper;

class SendInviteToUser
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * SendInviteEmailToUser constructor.
     *
     * @param User    $user
     * @param Company $company
     */
    public function __construct(
        private User $user,
        private Company $company,
    ) {
        Invite::deleteExisting($user->email, $company->id, Invite::COMPANY_USER_TYPE);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $token = $this->insertToDatabase();

        $url = route('admin.company.user.invite.link', [
            $this->company->id,
            $token,
            Crypt::encryptString($this->user->email),
        ]);

        $name = trans('mail.invited.company.name', ['name', $this->company->name]);
        $subject = trans('mail.subject.invited.company', ['name' => $this->company->name]);

        $this->user->notify(new InviteNotification($url, $name, $subject));
    }

    private function insertToDatabase(): string
    {
        $token = TokenGeneratorHelper::create();

        $userInvite = new Invite();
        $userInvite->type = Invite::COMPANY_USER_TYPE;
        $userInvite->email = $this->user->email;
        $userInvite->token = $token->getHashToken();
        $userInvite->company_id = $this->company->id;
        $userInvite->save();

        return $token->getToken();
    }
}
