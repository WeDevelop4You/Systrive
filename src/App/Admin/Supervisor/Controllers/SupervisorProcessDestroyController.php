<?php

namespace App\Admin\Supervisor\Controllers;

use App\Admin\Supervisor\Responses\SupervisorProcessDestroyResponse;
use Domain\Supervisor\Models\Supervisor;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class SupervisorProcessDestroyController
{
    /**
     * @param Supervisor $supervisor
     *
     * @return JsonResponse
     */
    public function index(Supervisor $supervisor): JsonResponse
    {
        return SupervisorProcessDestroyResponse::create($supervisor)->toJson();
    }

    /**
     * @param Supervisor $supervisor
     *
     * @return JsonResponse
     */
    public function action(Supervisor $supervisor): JsonResponse
    {
        $supervisor->delete();

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.deleted'))
            )
            ->toJson();
    }
}
