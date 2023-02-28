<?php

namespace App\Company\Cms\Responses;

use App\Company\Cms\Forms\CmsApiForm;
use App\Company\Cms\Forms\CmsTableApiForm;
use App\Company\Cms\Resources\CmsTableApiResource;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\DividerComponent;
use Support\Client\Components\Popups\Modals\ShowModal;
use Support\Client\Response;

class CmsTableApiResponse extends AbstractResponse
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
        $this->vuexNamespace = 'cms/table/api';
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CmsTableApiResource::make($this->table))
            ->addPopup(
                $this->getModel()
                    ->setWidth(1200)
                    ->setTitle(trans('word.api.api'))
                    ->setComponents([
                        CmsTableApiForm::create($this->table)->setVuexNamespace("{$this->vuexNamespace}/form"),
                        $this->createButtons(),
                        DividerComponent::create()->setClass('my-3'),
                        CmsApiForm::create()->setVuexNamespace('cms/api/form'),
                    ])
            );
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
     * @return WrapperComponent
     */
    private function createButtons(): WrapperComponent
    {
        return WrapperComponent::create()
            ->setClass('gap-3 mt-4')
            ->setComponents([
                BtnComponentType::create()
                    ->setColor()
                    ->setTitle(trans('word.save.save'))
                    ->setAction(
                        VuexAction::create()->dispatch(
                            "{$this->vuexNamespace}/update",
                            route('company.cms.table.api', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                            ])
                        )
                    ),
            ]);
    }
}
