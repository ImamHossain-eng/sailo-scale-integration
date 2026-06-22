<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->group('super-admin', [
            'auth',
            'role:super_admin',
        ]);
        $middleware->group('admin', [
            'auth',
            'role:admin|super_admin',
        ]);
        $middleware->group('operator', [
            'auth',
            'role:operator',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
