<?php

namespace Domain\Invite\Jobs;

use function config;
use Domain\Company\Mappings\CompanyTableMap;
use Domain\Company\Models\Company;
use Domain\Invite\Actions\CreateInviteAction;
use Domain\Invite\Mappings\InviteTableMap;
use Domain\Invite\Notifications\InviteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use function route;
use function trans;

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
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $token = (new CreateInviteAction($this->email, InviteTableMap::COMPANY_TYPE, $this->company))();

        if ($this->company->status === CompanyTableMap::EXPIRED_STATUS) {
            $this->company->status = CompanyTableMap::INVITED_STATUS;
            $this->company->save();
        }

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
}
