<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $view = parent::render($request, $e);

        if($request->expectsJson())
        {
            $view = match($e::class) {
                ValidationException::class => response()->apiFail('wrong_params', 422),
                ModelNotFoundException::class => response()->apiFail('not_found', 404),
                AuthenticationException::class => response()->apiFail('unauthorized', 401),
                HttpException::class => response()->apiFail($e->getMessage(), $e->getStatusCode()),
                default => response()->apiFail(config('app.debug') ? $e->getMessage() : 'internal_error', 500)
            };
        }

        return $view;
    }
}
