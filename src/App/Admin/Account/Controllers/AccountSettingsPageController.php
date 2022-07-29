<?php

namespace App\Admin\Account\Controllers;

use App\Admin\Account\Responses\AccountSettingsGitOverviewResponse;
use App\Admin\Account\Responses\AccountSettingsOverviewResponse;
use App\Admin\Account\Responses\AccountSettingsPersonalOverviewResponse;
use App\Admin\Account\Responses\AccountSettingsSecurityOverviewResponse;
use Illuminate\Http\JsonResponse;
use Support\Response\Actions\RouteAction;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
use Support\Response\Response;

class AccountSettingsPageController
{
    /**
     * @param string $page
     *
     * @return JsonResponse
     */
    public function index(string $page): JsonResponse
    {
        $response = match ($page) {
            'personal' => AccountSettingsPersonalOverviewResponse::create(),
            'security' => AccountSettingsSecurityOverviewResponse::create(),
            'git' => AccountSettingsGitOverviewResponse::create(),
            default => Response::create()
                ->addAction(
                    RouteAction::create()->goTo(
                        VueRouteHelper::create()
                            ->setName('account.settings')
                            ->setParams([
                                'page' => AccountSettingsOverviewResponse::DEFAULT_PAGE,
                            ])
                    )
                )
        };

        return $response->toJson();
    }
}
