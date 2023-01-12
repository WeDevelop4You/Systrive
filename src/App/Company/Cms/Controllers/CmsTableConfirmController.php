<?php

namespace App\Company\Cms\Controllers;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\NoAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\ConfirmModal;
use Support\Client\Response;
use Support\Enums\Component\ModalCloseType;

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
                            'cms/table/update',
                            route('company.cms.table.edit', [
                                $company->id,
                                $cms->id,
                                $table->id,
                            ])
                        )->setOnSuccessAction(
                            ChainAction::create()->setActions([
                                VuexAction::create()->commit('cms/table/form/resetForm'),
                                VuexAction::create()->closeAllModals(),
                            ])
                        ),
                        close: ModalCloseType::FAIL
                    )
            )
            ->toJson();
    }
}
