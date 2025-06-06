<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php',

    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth:sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // 'api' => [
            //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            //     'throttle:api',
            //     \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // ],

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
