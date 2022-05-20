<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
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
