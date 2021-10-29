<?php

    namespace App\Exceptions;

    use App\Exceptions\Handlers\ModelNotFoundException as ModelNotFoundExceptionHandler;
    use App\Exceptions\Handlers\UnauthorizedException as UnauthorizedExceptionHandler;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Spatie\Permission\Exceptions\UnauthorizedException;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;
    use Throwable;

    class Handler extends ExceptionHandler
    {
        /**
         * A list of the exception types that are not reported.
         *
         * @var array
         */
        protected $dontReport = [
            //
        ];

        /**
         * A list of the inputs that are never flashed for validation exceptions.
         *
         * @var array
         */
        protected $dontFlash = [
            'current_password',
            'password',
            'password_confirmation',
        ];

        /**
         * @var array
         */
        protected array $handlerCasts = [
            UnauthorizedException::class => UnauthorizedExceptionHandler::class,
            ModelNotFoundException::class => ModelNotFoundExceptionHandler::class,
        ];

        /**
         * Register the exception handling callbacks for the application.
         *
         * @return void
         */
        public function register()
        {
            foreach ($this->handlerCasts as $exception => $handlerCast) {
                $this->map($exception, function () use ($handlerCast) {
                    return new $handlerCast();
                });
            }
        }

        /**
         * @param Request   $request
         * @param Throwable $e
         *
         * @return JsonResponse|\Illuminate\Http\Response|ResponseCodes
         * @throws Throwable
         */
        public function render($request, Throwable $e)
        {
            $e = $this->prepareException($this->mapException($e));

            return parent::render($request, $e);
        }
    }
