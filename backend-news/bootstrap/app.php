<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use App\Exceptions\Handler;

// Custom providers
use App\Providers\RateLimiterServiceProvider;
use App\Providers\ScheduleServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        RateLimiterServiceProvider::class,
        ScheduleServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Add this line for API routes
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\JsonResponseMiddleware::class,
            \App\Http\Middleware\CorsMiddleware::class,
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();

