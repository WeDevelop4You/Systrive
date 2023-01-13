<?php

namespace App\Company\Role\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Response;
use Support\Utils\VuexNamespace;

class RoleOverviewResponse extends AbstractResponse
{
    /**
     * CompanyRoleOverviewResponse constructor.
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
        return Response::create()->addComponent(self::table($this->company));
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
            ->setTitle(trans('word.role.role'))
            ->setVuexNamespace(VuexNamespace::createCompanyWhenAdmin('roles/dataTable'))
            ->setHeaderRoute(route('company.role.table.headers', [
                $company->id,
            ]))
            ->setItemsRoute(route('company.role.table.items', [
                $company->id,
            ]))
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setSize()
                    ->setColor()
                    ->setTitle(trans('word.create.create'))
                    ->setAction(
                        VuexAction::create()->dispatch(
                            VuexNamespace::createCompanyWhenAdmin('roles/create'),
                            route('company.role.create', [
                                $company->id,
                            ])
                        )
                    )
            );
    }
}
