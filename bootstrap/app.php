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
        // Enregistrez votre middleware personnalisé ici
        $middleware->alias([
            'mairie' => \App\Http\Middleware\MairieMiddleware::class,
            'hopital' => \App\Http\Middleware\HopitalMiddleware::class,
            'doctor' => \App\Http\Middleware\DoctorMiddleware::class,
            'agent' => \App\Http\Middleware\AgentMiddleware::class,
            'director' => \App\Http\Middleware\DirectorMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
