<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Requests\SupervisorProcessRequest;
use App\Admin\Supervisor\Responses\SupervisorProcessCreateResponse;
use Domain\Supervisor\Actions\SaveSupervisorProcessAction;
use Domain\Supervisor\DataTransferObjects\SupervisorProcessData;
use Exception;
use Illuminate\Http\JsonResponse;
use Support\Exceptions\ActionErrorException;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;

class SupervisorProcessCreateController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return SupervisorProcessCreateResponse::create()->toJson();
    }

    /**
     * @param SupervisorProcessRequest $request
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function action(SupervisorProcessRequest $request): JsonResponse
    {
        $data = new SupervisorProcessData(...$request->validated());

        try {
            (new SaveSupervisorProcessAction())($data);
        } catch (ActionErrorException $e) {
            return Response::create()
                ->addErrors('config', [$e->getMessage()])
                ->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.success.saved'))
            )
            ->addAction(
                VuexAction::create()->dispatch(
                    'supervisor/overview/component',
                    route('admin.admin.supervisor.overview')
                )
            )
            ->toJson();
    }
}
