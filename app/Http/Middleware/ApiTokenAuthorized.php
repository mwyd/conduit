<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\RestApiKey;

class ApiTokenAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try
        {
            $token = RestApiKey::findOrFail(hash('md5', $request->header('token')));
            $request->merge(['user_id' => $token->user_id]);
        }
        catch(\Exception $e)
        {
            return response()->apiFail('unauthorized', 401);
        }

        return $next($request);
    }
}
