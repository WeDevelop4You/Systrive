<?php

namespace Support\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use ReflectionException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Support\Exceptions\Handlers\ModelNotFoundExceptionHandler;
use Support\Exceptions\Handlers\QueryExceptionHandler;
use Support\Exceptions\Handlers\UnauthorizedExceptionHandler;
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
//        QueryException::class => QueryExceptionHandler::class,
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
            $this->map($exception, fn () => new $handler());
        }

        $this->reportable(function (Throwable $e) {
            if (App::bound('sentry')) {
                App::make('sentry')->captureException($e);
            }
        });
    }

    /**
     * Try to render a response from request and exception via render callbacks.
     *
     * @param Request   $request
     * @param Throwable $e
     *
     * @throws ReflectionException
     * @return mixed|void
     */
    protected function renderViaCallbacks($request, Throwable $e)
    {
        if (method_exists($e, 'render')) {
            $response = $e->render($request);

            if ($response) {
                return $response;
            }
        }

        return parent::renderViaCallbacks($request, $e);
    }
}
