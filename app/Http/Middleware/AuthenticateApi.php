<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('api-key');

        if ($apiKey != 'helloatg') {
            return response()->json(['status' => 0, 'message' => 'Invalid API key']);
        }

        return $next($request);
    }

}
