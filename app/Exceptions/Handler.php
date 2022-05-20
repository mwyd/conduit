<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $view = parent::render($request, $e);

        if ($request->expectsJson()) {
            $message = match ($e::class) {
                ValidationException::class => ['wrong_params', 422],
                ModelNotFoundException::class => ['not_found', 404],
                AuthenticationException::class => ['forbidden', 403],
                AuthorizationException::class => ['unauthorized', 401],
                HttpException::class => [$e->getMessage(), $e->getStatusCode()],
                default => [config('app.debug') ? $e->getMessage() : 'internal_error', 500]
            };

            $view = response()->apiFail(...$message);
        }

        return $view;
    }
}
