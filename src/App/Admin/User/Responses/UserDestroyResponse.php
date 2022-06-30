<?php

namespace App\Admin\User\Responses;

use Domain\User\Models\User;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

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
                DeleteModal::create('users')
                    ->addFooterForceDeleteButton(
                        RequestAction::create()
                            ->delete(route('admin.admin.user.destroy.force', [
                                $this->user->id,
                            ]))
                    )
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(route('admin.admin.user.destroy', [
                                $this->user->id,
                            ]))
                    )
                    ->addFooterCancelButton()
            );
    }
}
