<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\Handler;

class VerifySpringApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = config('app.spring_api_key');

        $isApiKeyValid = (!empty($apiKey) && $request->header('x-api-key') == $apiKey);

        $headers = [
            'Access-Control-Allow-Origin' => env('FRONTEND_DOMAIN'),
            'Access-Control-Allow-Credentials' => true
        ];

        if (!$isApiKeyValid) {
            return response()->json([
                'Success' => false,
                'ErrorMessage' => 'Access Denied'
            ], 403)->withHeaders($headers);
        }
        
        return $next($request);
    }
}
