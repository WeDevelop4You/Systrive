<?php

namespace App\Account\Settings\Controllers;

use App\Account\Settings\Responses\SettingsPersonalOverviewResponse;
use App\Account\Settings\Responses\SettingsSecurityOverviewResponse;
use Illuminate\Http\JsonResponse;
use Support\Client\Actions\RouteAction;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Response;

class SettingsPageController
{
    /**
     * @param string $page
     *
     * @return JsonResponse
     */
    public function index(string $page): JsonResponse
    {
        $response = match ($page) {
            'personal' => SettingsPersonalOverviewResponse::create(),
            'security' => SettingsSecurityOverviewResponse::create(),
            default => Response::create()->addAction(
                RouteAction::create()->goTo(VueRouteHelper::createAccountSettings())
            )
        };

        return $response->toJson();
    }
}
