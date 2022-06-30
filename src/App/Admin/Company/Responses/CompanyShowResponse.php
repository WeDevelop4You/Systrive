<?php

namespace App\Admin\Company\Responses;

use App\Admin\Company\Resources\CompanyShowResource;
use App\Admin\Company\Role\Responses\CompanyRoleOverviewResponse;
use App\Admin\Company\User\Responses\CompanyUserOverviewResponse;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Items\ItemURLComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\ListComponent;
use Support\Response\Components\Popups\Modals\ShowModal;
use Support\Response\Response;

class CompanyShowResponse extends AbstractResponse
{
    /**
     * CompanyCreateResponse constructor.
     *
     * @param Company $company
     * @param bool    $showPopup
     */
    protected function __construct(
        private readonly Company $company,
        private readonly bool $showPopup
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $response = Response::create()
            ->addData(CompanyShowResource::make($this->company));

        if ($this->showPopup) {
            $response->addPopup(
                ShowModal::create('companies')
                    ->setTitle($this->company->name)
                    ->addComponent(
                        RowComponent::create()
                            ->setCols([
                                $this->createCardList(),
                                $this->createTables(),
                            ])
                    )
            );
        }

        return $response;
    }

    /**
     * @return ColComponent
     */
    private function createCardList(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(3)
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.details'))
                    ->addBody(
                        ListComponent::create()
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.id.id'))
                                    ->setValue($this->company->id),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->company->name),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.email.email'))
                                    ->setValue($this->company->email),
                                ItemURLComponent::create()
                                    ->setLabel(trans('word.domain.domain'))
                                    ->setValue($this->company->domain),
                            ])
                            ->addDivider()
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.information.information'))
                                    ->setValue($this->company->information),
                            ])
                    )
                    ->addAdditionalBodyClass('pa-0')
            );
    }

    /**
     * @return ColComponent
     */
    private function createTables(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(9)
            ->setComponent(
                RowComponent::create()
                    ->setCols([
                        ColComponent::create()->setComponent(CompanyUserOverviewResponse::table($this->company)),
                        ColComponent::create()->setComponent(CompanyRoleOverviewResponse::table($this->company)),
                    ])
            );
    }
}
