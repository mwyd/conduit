<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiResponseProvider extends ServiceProvider
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
        Response::macro('apiSuccess', function($data, $httpCode = 200) {
            return Response::json([
                'success'   => true,
                'data'      => $data
            ], $httpCode);
        });

        Response::macro('apiFail', function($message, $httpCode = 400) {
            return Response::json([
                'success'       => false,
                'error_message' => $message
            ], $httpCode);
        });
    }
}
