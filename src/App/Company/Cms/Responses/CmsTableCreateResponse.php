<?php

namespace App\Company\Cms\Responses;

use App\Company\Cms\Forms\CmsTableForm;
use App\Company\Cms\Resources\CmsTableResource;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Overviews\Tables\LocaleTableComponent;
use Support\Client\Components\Popups\Modals\ShowModal;
use Support\Client\Response;

class CmsTableCreateResponse extends AbstractResponse
{
    /**
     * @var ShowModal
     */
    private ShowModal $model;

    /**
     * @var string
     */
    private readonly string $vuexNamespace;

    /**
     * CmsTableResponse constructor.
     *
     * @param Company $company
     * @param Cms     $cms
     */
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
    ) {
        $this->vuexNamespace = 'cms/table/form';
    }

    /**
     * @return ShowModal
     */
    private function getModel(): ShowModal
    {
        if (!isset($this->model)) {
            $this->model = ShowModal::create();
        }

        return $this->model;
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CmsTableResource::make(new CmsTable()))
            ->addAction(VuexAction::create()->dispatch(
                'cms/table/columns/list',
                route('company.cms.table.column.create.list', [
                    $this->company->id,
                    $this->cms->id,
                ])
            ))
            ->addPopup(
                $this->getModel()
                    ->setWidth(1200)
                    ->setTitle(trans('word.create.create'))
                    ->setComponents([
                        CmsTableForm::create()->setVuexNamespace($this->vuexNamespace),
                        $this->createTable(),
                        $this->createButtons(),
                    ])
            );
    }

    /**
     * @return LocaleTableComponent
     */
    private function createTable(): LocaleTableComponent
    {
        return LocaleTableComponent::create()
            ->setSearchable()
            ->setDisablePagination()
            ->setTitle(trans('word.columns'))
            ->setVuexNamespace('cms/table/columns/dataTable')
            ->setHeaderRoute(
                route('company.cms.table.column.create.table.headers', [
                    $this->company->id,
                    $this->cms->id,
                ])
            )
            ->setItemsRoute(
                route('company.cms.table.column.create.table.items', [
                    $this->company->id,
                    $this->cms->id,
                ])
            )
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setColor()
                    ->setTitle(trans('word.create.create'))
                    ->setAction(VuexAction::create()->dispatch(
                        'cms/table/columns/create',
                        route('company.cms.table.column.create', [
                            $this->company->id,
                            $this->cms->id,
                        ])
                    ))
            );
    }

    /**
     * @return MultipleButtonComponent
     */
    private function createButtons(): MultipleButtonComponent
    {
        $closeAction = ChainAction::create()->setActions([
            VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"),
            VuexAction::create()->closeModal($this->getModel()->getIdentifier()),
        ]);

        return MultipleButtonComponent::create()
            ->setClass('gap-3 mt-4')
            ->setButtons([
                ButtonComponent::create()
                    ->setTitle(trans('word.cancel.cancel'))
                    ->setAction($closeAction),
                ButtonComponent::create()
                    ->setColor()
                    ->setTitle(trans('word.save.save'))
                    ->setAction(
                        VuexAction::create()->dispatch(
                            'cms/table/store',
                            route('company.cms.table.create', [
                                $this->company->id,
                                $this->cms->id,
                            ])
                        )->setOnSuccessAction($closeAction)
                    ),
            ]);
    }
}
