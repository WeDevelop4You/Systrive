<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Support\Helpers\Response\Action\Methods\RouteMethod;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*') && $request->routeIs('admin.*')) {
                $response = new Response(ResponseCodes::HTTP_NOT_FOUND);
                $response->addPopup(trans('response.error.not_found'));
                $response->addAction(new RouteMethod())->setActionGoToLastRoute();

                return $response->toJson();
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
