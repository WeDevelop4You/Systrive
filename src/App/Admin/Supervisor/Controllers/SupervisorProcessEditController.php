<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Requests\SupervisorProcessRequest;
use App\Admin\Supervisor\Responses\SupervisorProcessEditResponse;
use Domain\Supervisor\Actions\SaveSupervisorProcessAction;
use Domain\Supervisor\DataTransferObjects\SupervisorProcessData;
use Domain\Supervisor\Models\Supervisor;
use Illuminate\Http\JsonResponse;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;

class SupervisorProcessEditController
{
    public function index(Supervisor $supervisor): JsonResponse
    {
        return SupervisorProcessEditResponse::create($supervisor)->toJson();
    }

    public function action(SupervisorProcessRequest $request, Supervisor $supervisor): JsonResponse
    {
        $data = new SupervisorProcessData(...$request->validated());

        (new SaveSupervisorProcessAction($supervisor))($data);

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.success.saved'))
            )
            ->toJson();
    }
}
