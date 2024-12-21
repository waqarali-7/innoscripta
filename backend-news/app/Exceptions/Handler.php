<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Handler
{
    /**
     * Report or log an exception.
     */
    public function report(Throwable $e): void
    {
        Log::error($e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render(Request $request, Throwable $e): JsonResponse
    {
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'errors' => config('app.debug') ? [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ] : null,
        ], $statusCode);
    }
}
