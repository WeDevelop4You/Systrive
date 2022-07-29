<?php

namespace App\Admin\Company\Role\Responses;

use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Response;

class CompanyRoleOverviewResponse extends AbstractResponse
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
        return Response::create()
            ->addAction(VuexAction::create()->dispatch('permissions/getList'))
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
            ->setTitle(trans('word.role.role'))
            ->setVuexNamespace('company/roles/dataTable')
            ->setHeaderUrl(route('admin.company.role.table.headers', [
                $company->id,
            ]))
            ->setItemsUrl(route('admin.company.role.table.items', [
                $company->id,
            ]))
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setSize()
                    ->setColor()
                    ->setTitle(trans('word.create.create'))
                    ->setAction(
                        VuexAction::create()->dispatch(
                            'company/roles/create',
                            route('admin.company.role.create', [
                                $company->id,
                            ])
                        )
                    )
            );
    }
}
