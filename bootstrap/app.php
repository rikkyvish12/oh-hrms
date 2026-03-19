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
            'ip.check' => \App\Http\Middleware\CheckIpAddress::class,
            'employee.password.set' => \App\Http\Middleware\EnsureEmployeePasswordSet::class,
        ]);
        
        // Configure guest middleware to redirect to generic login route
        $middleware->redirectGuestsTo(fn ($request) => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
