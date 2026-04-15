<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )


    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        // Register global middleware here if needed

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'admin'    => \App\Http\Middleware\AdminOnly::class,
            'editor'   => \App\Http\Middleware\EditorOnly::class,
            'employer' => \App\Http\Middleware\EmployerOnly::class,
            'active' => \App\Http\Middleware\CheckIfActive::class,
            'subscribed' => \App\Http\Middleware\EnsureUserHasSubscription::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Customize exception handling here if needed
    })
    ->create();
