<?php

    namespace Domain\User\Actions;

    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    class UpdateUserLocaleAction
    {
        public function __invoke(string $locale): void
        {
            App::setLocale($locale);

            if (Auth::check()) {
                $user = Auth::user();
                $user->locale = $locale;
                $user->save();
            } else {
                Session::put('locale', $locale);
            }
        }
    }
