<?php

namespace App\Admin\Company\User\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Response;

class CompanyUserOverviewResponse extends AbstractResponse
{
    /**
     * CompanyUserOverviewResponse constructor.
     *
     * @param Company $company
     */
    public function __construct(
        private readonly Company $company
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(self::table($this->company));
    }

    /**
     * @param Company $company
     *
     * @return ServerTableComponent
     */
    public static function table(Company $company): ServerTableComponent
    {
        return ServerTableComponent::create()
            ->setSearchable()
            ->setTitle(trans('word.user.access'))
            ->setVuexNamespace('company/users')
            ->setHeaderUrl(route('admin.company.user.table.headers', [
                $company->id,
            ]))
            ->setItemsUrl(route('admin.company.user.table.items', [
                $company->id,
            ]))
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setColor()
                    ->setSize()
                    ->setTitle(trans('word.invite.invite'))
                    ->setAction(
                        VuexAction::create()
                            ->dispatch(
                                'company/users/create',
                                route('admin.company.user.invite', [
                                    $company->id,
                                ])
                            )
                    )
            );
    }
}
