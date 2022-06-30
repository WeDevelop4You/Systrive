<?php

namespace App\Admin\Git\Controllers;

use Domain\Git\Actions\CreateOrUpdateGitAccountAction;
use Domain\Git\Enums\GitServiceTypes;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GitAuthenticationController
{
    /**
     * @param GitServiceTypes $service
     *
     * @return RedirectResponse|SymfonyRedirectResponse
     */
    public function index(GitServiceTypes $service): SymfonyRedirectResponse|RedirectResponse
    {
        return Socialite::driver($service->value)
            ->setScopes($service->scopes())
            ->redirect();
    }

    /**
     * @param GitServiceTypes $service
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function action(GitServiceTypes $service): Redirector|Application|RedirectResponse
    {
        /** @var User $serviceUser */
        $serviceUser = Socialite::driver($service->value)->user();

        (new CreateOrUpdateGitAccountAction($service))($serviceUser);

        Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText('response.success.added'))
            ->toSession();

        return redirect('/s/git');
    }
}
