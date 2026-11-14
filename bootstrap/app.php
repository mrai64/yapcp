<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // log add
        $middleware->web(append: [
            \App\Http\Middleware\LogContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // added check for db offline
        $exceptions->render(function (QueryException $e, Request $request) {
            // connection refused
            if ($e->getCode() == 2002 || str_contains($e->getMessage(), 'Connection refused')) {
                return response()->view(
                    view: 'errors.db-offline',
                    data: [],
                    status: 500
                );
            }
        });
    })->create();
