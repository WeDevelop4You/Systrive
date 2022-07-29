<?php

    namespace Domain\Invite\Jobs;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\states\CompanyInvitedState;
    use Domain\Company\states\CompanyUserRequestedState;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Domain\User\Mappings\UserTableMap;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;

    class CheckInviteHasExpired implements ShouldQueue
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
            $relationshipCompanyUsers = createRelationshipString(
                InviteTableMap::RELATIONSHIP_COMPANY,
                CompanyTableMap::RELATIONSHIP_USERS
            );

            Invite::whereExpired()
                ->whereHas($relationshipCompanyUsers, function (Builder $query) {
                    $query->whereColumn(UserTableMap::TABLE_ID, InviteTableMap::TABLE_USER_ID)
                        ->where(CompanyUserTableMap::TABLE_STATUS, CompanyUserStatusTypes::REQUESTED)
                        ->withTrashed();
                })->orWhereHas(InviteTableMap::RELATIONSHIP_COMPANY, function (Builder $query) {
                    $query->whereColumn(CompanyTableMap::TABLE_ID, InviteTableMap::TABLE_COMPANY_ID)
                        ->where(CompanyTableMap::TABLE_STATUS, CompanyStatusTypes::INVITED);
                })->get()->each(function (Invite $invite) {
                    $invite->type->getStatus($invite)
                        ->changeStateWhen(CompanyInvitedState::class, CompanyUserRequestedState::class);
                });
        }
    }
