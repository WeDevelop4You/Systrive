<?php

namespace Domain\Company\Jobs;

use Domain\Company\Models\Company;
use Domain\Invite\Models\Invite;
use Domain\User\Notifications\InviteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use Support\Helpers\TokenGeneratorHelper;

class SendCompanyInvite
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * SendInviteEmailToUser constructor.
     *
     * @param string  $email
     * @param Company $company
     */
    public function __construct(
        private string $email,
        private Company $company,
    ) {
        Invite::deleteExisting($email, $company->id, Invite::NEW_COMPANY_TYPE);
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
            Crypt::encryptString($this->email),
        ]);

        $appName = config('app.name');

        $name = $appName;
        $subject = trans('mail.subject.invited.new.company', ['name' => $appName]);

        Notification::route('mail', $this->email)->notify(new InviteNotification($url, $name, $subject));
    }

    private function insertToDatabase(): string
    {
        $token = TokenGeneratorHelper::create();

        $userInvite = new Invite();
        $userInvite->type = Invite::NEW_COMPANY_TYPE;
        $userInvite->email = $this->email;
        $userInvite->token = $token->getHashToken();
        $userInvite->company_id = $this->company->id;
        $userInvite->save();

        return $token->getToken();
    }
}
