<?php

namespace Domain\Invite\Jobs;

use Domain\Company\Models\Company;
use Domain\Invite\Actions\CreateInviteAction;
use Domain\Invite\Enums\InviteTypes;
use Domain\Invite\Notifications\InviteNotification;
use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

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
        private readonly User $user,
        private readonly Company $company,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $token = (new CreateInviteAction($this->user, $this->company, InviteTypes::USER))();

        $url = route('admin.invite.link', [
            $this->company->id,
            $token,
            Crypt::encryptString($this->user->email),
        ]);

        $name = trans('mail.invited.company.name', ['name', $this->company->name]);
        $subject = trans('mail.subject.invited.company', ['name' => $this->company->name]);

        $this->user->notify(new InviteNotification($url, $name, $subject));
    }
}
