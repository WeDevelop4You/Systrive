<?php

namespace App\Admin\Cms\Controllers\Table;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Enums\Component\ModalCloseType;
use Support\Response\Actions\AbstractAction;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\NoAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Modals\ConfirmModal;
use Support\Response\Response;

class CmsTableConfirmController
{
    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        return Response::create()
            ->addPopup(
                ConfirmModal::create()
                    ->setTitle('modal.confirm.are.you.sure.title')
                    ->setText('modal.confirm.are.you.sure.text')
                    ->addFooterCancelButton(
                        NoAction::create(),
                        close: ModalCloseType::SUCCESS
                    )
                    ->addFooterSubmitButton(
                        VuexAction::create()->dispatch(
                            'company/cms/table/update',
                            route('admin.company.cms.table.edit', [
                                $company->id,
                                $cms->id,
                                $table->id
                            ])
                        )->setOnSuccessAction(
                            ChainAction::create()->setActions([
                                VuexAction::create()->commit('company/cms/table/form/resetForm'),
                                VuexAction::create()->closeAllModals(),
                            ])
                        ),
                        close: ModalCloseType::FAIL
                    )
            )
            ->toJson();
    }
}
