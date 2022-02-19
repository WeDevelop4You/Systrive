<?php

    namespace Domain\Invite\Jobs;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Invite\Actions\ChangeInviteStatusAction;
    use Domain\Invite\Models\Invite;
    use Illuminate\Bus\Queueable;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
            Invite::whereExpired()->whereUserType()
                ->whereHas('company.users', function (Builder $query) {
                    $query->whereColumn('users.email', 'invites.email')
                        ->where('company_user.status', CompanyUserStatusTypes::REQUESTED)
                        ->withTrashed();
                })->with([
                    'company',
                    'user' => function (BelongsTo $query) {
                        $query->withTrashed();
                    },
                ])->get()->each(function (Invite $invite) {
                    (new ChangeInviteStatusAction(CompanyUserStatusTypes::REQUESTED, CompanyUserStatusTypes::EXPIRED))($invite);
                });
        }
    }
