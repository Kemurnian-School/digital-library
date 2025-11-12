<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'student.auth' => \App\Http\Middleware\StudentAuth::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(function (Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // For future 'user' routes
            // if ($request->is('user') || $request->is('user/*')) {
            //     return route('user.login');
            // }

            // Default for all else
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ...
    })
    ->create();
