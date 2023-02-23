<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('apiSuccess', function (mixed $data, int $httpCode = 200) {
            return Response::json([
                'success' => true,
                'data' => $data
            ], $httpCode);
        });

        Response::macro('apiFail', function (string $message, int $httpCode = 400) {
            return Response::json([
                'success' => false,
                'error_message' => $message
            ], $httpCode);
        });
    }
}
