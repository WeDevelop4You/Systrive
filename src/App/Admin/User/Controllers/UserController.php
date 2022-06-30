<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Requests\UpdateUserProfileRequest;
    use App\Admin\User\Resources\UserResource;
    use Domain\User\Actions\UpdateUserEmailAction;
    use Domain\User\Actions\UpdateUserProfileAction;
    use Domain\User\DataTransferObjects\UserProfileData;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Response\Actions\ChainAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class UserController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $response = new Response();
            $response->addData(UserResource::make(Auth::user()));

            return $response->toJson();
        }

        public function action(UpdateUserProfileRequest $request): JsonResponse
        {
            $user = Auth::user();
            $data = new UserProfileData(...$request->validated());

            (new UpdateUserProfileAction($user))($data);
            (new UpdateUserEmailAction($user))($data->email);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.success.saved'))
                )
                ->addAction(
                    ChainAction::create()
                        ->setActions([
                            VuexAction::create()
                                ->commit('user/auth/form/resetErrors'),
                            VuexAction::create()
                                ->dispatch('user/auth/getOne'),
                        ])
                )
                ->toJson();
        }
    }
