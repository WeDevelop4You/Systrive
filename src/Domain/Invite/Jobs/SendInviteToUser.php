<?php

namespace Domain\Invite\Jobs;

use Domain\Company\Models\Company;
use Domain\Invite\Actions\CreateInviteAction;
use Domain\Invite\Mappings\InviteTableMap;
use Domain\Invite\Notifications\InviteNotification;
use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use function route;
use function trans;

class SendInviteToUser
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    private User $user;

    /**
     * SendInviteEmailToUser constructor.
     *
     * @param string|User $notifiable
     * @param Company     $company
     */
    public function __construct(
        User|string $notifiable,
        private Company    $company,
    ) {
        $this->user = $notifiable instanceof User
            ? $notifiable
            : User::where('email', $notifiable)->firstOrFail();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $token = (new CreateInviteAction($this->user->email, InviteTableMap::USER_TYPE, $this->company))();

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
