<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Requests\SupervisorProcessRequest;
use App\Admin\Supervisor\Responses\SupervisorProcessEditResponse;
use Domain\Supervisor\Actions\SaveSupervisorProcessAction;
use Domain\Supervisor\DataTransferObjects\SupervisorProcessData;
use Domain\Supervisor\Models\Supervisor;
use Exception;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Exceptions\Custom\ActionErrorException;

class SupervisorProcessEditController
{
    /**
     * @param Supervisor $supervisor
     *
     * @return JsonResponse
     */
    public function index(Supervisor $supervisor): JsonResponse
    {
        return SupervisorProcessEditResponse::create($supervisor)->toJson();
    }

    /**
     * @param SupervisorProcessRequest $request
     * @param Supervisor               $supervisor
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function action(SupervisorProcessRequest $request, Supervisor $supervisor): JsonResponse
    {
        $data = new SupervisorProcessData(...$request->validated());

        try {
            (new SaveSupervisorProcessAction($supervisor))($data);
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
            ->toJson();
    }
}
