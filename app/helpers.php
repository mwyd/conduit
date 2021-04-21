<?php

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

if(!function_exists('exceptionToHttpCode'))
{
    function exceptionToHttpCode($exception)
    {
        $err = match($exception::class) {
            ValidationException::class => ['message' => 'wrong_params', 'code' => 422],
            ModelNotFoundException::class => ['message' => 'not_found', 'code' => 404],
            default => ['message' => 'internal_error', 'code' => 500]
        };
        
        return $err;
    }
}