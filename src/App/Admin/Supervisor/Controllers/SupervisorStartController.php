<?php

namespace App\Admin\Supervisor\Controllers;

use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Services\Supervisor;

class SupervisorStartController
{
    /**
     * @param string|null $name
     *
     * @return JsonResponse
     */
    public function action(?string $name = null): JsonResponse
    {
        if (\is_null($name)) {
            $successful = Supervisor::api()->startAllProcesses();
        } else {
            $successful = Supervisor::api()->startProcess($name);
        }

        if ($successful === true) {
            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.success.supervisor.start'))
                )
                ->toJson();
        }
    }
}
