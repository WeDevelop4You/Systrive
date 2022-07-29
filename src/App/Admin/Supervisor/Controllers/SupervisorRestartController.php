<?php

namespace App\Admin\Supervisor\Controllers;

use Illuminate\Http\JsonResponse;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Support\Services\Supervisor;

class SupervisorRestartController
{
    /**
     * @param string $name
     *
     * @return JsonResponse
     */
    public function action(string $name): JsonResponse
    {
        $successfulStarted = false;
        $successfulStopped = Supervisor::api()->stopProcess($name);

        if ($successfulStopped === true) {
            $successfulStarted = Supervisor::api()->startProcess($name);
        }

        if ($successfulStarted === true) {
            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.success.supervisor.restart'))
                )
                ->toJson();
        }
    }
}
