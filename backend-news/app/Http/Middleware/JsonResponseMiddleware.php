<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Throwable;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request and ensure JSON responses for exceptions.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Force the request to expect a JSON response
            $request->headers->set('Accept', 'application/json');
            return $next($request);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ] : null,
            ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
        }
    }
}
