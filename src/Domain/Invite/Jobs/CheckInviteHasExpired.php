<?php

    namespace Domain\Invite\Jobs;

    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Invite\Actions\ChangeInviteStatusAction;
    use Domain\Invite\Models\Invite;
    use Illuminate\Bus\Queueable;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;

    class CheckInviteHasExpired
    {
        use Dispatchable;
        use InteractsWithQueue;
        use Queueable;
        use SerializesModels;

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle(): void
        {
            Invite::whereExpired()->whereUserType()->with('company')->get()->each(function (Invite $invite) {
                (new ChangeInviteStatusAction(CompanyUserTableMap::REQUESTED_STATUS, CompanyUserTableMap::EXPIRED_STATUS))($invite);
            });
        }
    }
