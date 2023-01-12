<?php

namespace Support\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Support\Exceptions\Handlers\ModelNotFoundExceptionHandler;
use Support\Exceptions\Handlers\QueryExceptionHandler;
use Support\Exceptions\Handlers\UnauthorizedExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
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
    protected array $handlers = [
        QueryException::class => QueryExceptionHandler::class,
        UnauthorizedException::class => UnauthorizedExceptionHandler::class,
        ModelNotFoundException::class => ModelNotFoundExceptionHandler::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        foreach ($this->handlers as $exception => $handler) {
            $this->map($exception, fn (Exception $e) => new $handler(
                $e->getMessage(),
                is_int($e->getCode()) ? $e->getCode() : 0,
                $e->getPrevious()
            ));
        }

        $this->reportable(function (Throwable $e) {
            if (App::bound('sentry')) {
                App::make('sentry')->captureException($e);
            }
        });
    }

    /**
     * @param           $request
     * @param Throwable $e
     *
     * @throws Throwable
     *
     * @return JsonResponse|Response|SymfonyResponse
     */
    public function render($request, Throwable $e): Response|JsonResponse|SymfonyResponse
    {
        return parent::render($request, $this->mapException($e));
    }
}
