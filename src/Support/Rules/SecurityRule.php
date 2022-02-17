<?php

    namespace Support\Rules;

    use Domain\User\Models\User;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\Translation\Translator;
    use Illuminate\Contracts\Validation\DataAwareRule;
    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\SecurityHelper;

    class SecurityRule implements Rule, DataAwareRule
    {
        private Collection $data;

        public function __construct(
            public bool $creating = false
        ) {
        }

        public function setData($data)
        {
            $this->data = Collection::make($data);
        }

        /**
         * @param string $attribute
         * @param mixed  $value
         *
         * @return bool
         */
        public function passes($attribute, $value): bool
        {
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $user = User::whereEmail($this->data->get('email'))->first();
            }

            $security = SecurityHelper::create($user->security);

            if ($security->enabled($this->creating)) {
                if (!$this->creating && $this->data->has('recovery_code')) {
                    return $security->verifyRecoveryCode($this->data->get('recovery_code'));
                }

                return $security->verify($value);
            }

            return true;
        }

        /**
         * @return Application|array|string|Translator|null
         */
        public function message(): array|string|Translator|Application|null
        {
            return trans('validation.invalid.code');
        }
    }
