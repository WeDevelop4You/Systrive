<?php

namespace App\Admin\User\Responses;

use Domain\User\Models\User;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;

class UserDestroyResponse extends AbstractResponse
{
    public function __construct(
        private readonly User $user
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                DeleteModal::create('users/dataTable')
                    ->addFooterForceDeleteButton(
                        RequestAction::create()
                            ->delete(route('admin.user.destroy.force', [
                                $this->user->id,
                            ]))
                    )
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(route('admin.user.destroy', [
                                $this->user->id,
                            ]))
                    )
                    ->addFooterCancelButton()
            );
    }
}
