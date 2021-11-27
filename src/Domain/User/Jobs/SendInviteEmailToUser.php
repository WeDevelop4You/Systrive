<?php

namespace Domain\User\Jobs;

use Domain\Company\Models\Company;
use Domain\User\Mails\UserInviteMail;
use Domain\User\Models\User;
use Domain\User\Models\UserInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Encryption\MissingAppKeyException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendInviteEmailToUser implements ShouldQueue
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
     * @param string  $type
     */
    public function __construct(
        private User $user,
        private Company $company,
        private string $type,
    ) {
        UserInvite::deleteExisting($user->email, $company->id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $token = $this->insertToDatabase();

        $url = route('admin.company.user.invite.accepted', [
            $this->company->id,
            $token,
            Crypt::encryptString($this->user->email)
        ]);

        if ($this->type === UserInvite::INVITE_USER_TYPE) {
            $name = $this->company->name;
            $subject = trans('mail.subject.invited.company', ['name' => $this->company->name]);
        } else {
            $appName = config('app.name');

            $name = $appName;
            $subject = trans('mail.subject.invited.new.company', ['name' => $appName]);
        }

        Mail::to($this->user)->send(new UserInviteMail($url, $name, $subject));
    }

    private function getHashKey(): string
    {
        $key = env('APP_KEY');

        if (Str::startsWith($key, 'base64:')) {
            return base64_decode(substr($key, 7));
        }

        throw new MissingAppKeyException();
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    private function createNewToken(): string
    {
        return hash_hmac('sha256', Str::random(40), $this->getHashKey());
    }

    private function insertToDatabase(): string
    {
        $token = $this->createNewToken();

        $userInvite = new UserInvite();
        $userInvite->type = $this->type;
        $userInvite->email = $this->user->email;
        $userInvite->token = Hash::make($token);
        $userInvite->company_id = $this->company->id;
        $userInvite->save();

        return $token;
    }
}
