<?php

namespace App\Admin\Cms\Responses\Table;

use App\Admin\Cms\Forms\CmsTableForm;
use App\Admin\Cms\Resources\CmsTableResource;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Overviews\Tables\LocaleTableComponent;
use Support\Response\Components\Popups\Modals\ShowModal;
use Support\Response\Response;

class CmsTableEditResponse extends AbstractResponse
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
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     */
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly CmsTable $table
    ) {
        $this->vuexNamespace = 'company/cms/table/form';
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
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CmsTableResource::make($this->table))
            ->addAction(VuexAction::create()->dispatch(
                'company/cms/table/columns/list',
                route('admin.company.cms.table.column.edit.list', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                ])
            ))
            ->addPopup(
                $this->getModel()
                    ->setWidth(1200)
                    ->setTitle(trans('word.edit.edit'))
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
            ->setVuexNamespace('company/cms/table/columns/dataTable')
            ->setHeaderUrl(
                route('admin.company.cms.table.column.edit.table.headers', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                ])
            )
            ->setItemsUrl(
                route('admin.company.cms.table.column.edit.table.items', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                ])
            )
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setColor()
                    ->setTitle(trans('word.create.create'))
                    ->setAction(VuexAction::create()->dispatch(
                        'company/cms/table/columns/create',
                        route('admin.company.cms.table.column.create', [
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
        return MultipleButtonComponent::create()
            ->addClass('gap-3 mt-4')
            ->setButtons([
                ButtonComponent::create()
                    ->setTitle(trans('word.cancel.cancel'))
                    ->setAction(
                        ChainAction::create()->setActions([
                            VuexAction::create()->commit("{$this->vuexNamespace}/resetForm"),
                            VuexAction::create()->closeModal($this->getModel()->getIdentifier()),
                        ])
                    ),
                ButtonComponent::create()
                    ->setColor()
                    ->setTitle(trans('word.save.save'))
                    ->setAction(
                        RequestAction::create()->get(
                            route('admin.company.cms.table.confirm', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ])
                        )
                    )
                ,
            ]);
    }
}
