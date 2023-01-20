<?php

namespace App\Company\User\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Response;
use Support\Utils\VuexNamespace;

class UserOverviewResponse extends AbstractResponse
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
     * {@inheritDoc}
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
            ->setVuexNamespace(
                VuexNamespace::createCompanyWhenAdmin('users/dataTable')
            )
            ->setHeaderRoute(route('company.user.table.headers', $company->id))
            ->setItemsRoute(route('company.user.table.items', $company->id))
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setColor()
                    ->setSize()
                    ->setTitle(trans('word.invite.invite'))
                    ->setAction(
                        VuexAction::create()
                            ->dispatch(
                                VuexNamespace::createCompanyWhenAdmin('users/create'),
                                route('company.user.invite', $company->id)
                            )
                    )
            );
    }
}
