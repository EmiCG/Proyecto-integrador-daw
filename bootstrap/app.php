<?php

//use Fruitcake\Cors\HandleCors;
//use App\Http\Middleware\HandleCors;
//use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Middleware\HandleCors as MiddlewareHandleCors;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //$middleware->append(MiddlewareHandleCors::class); // Middleware para CORS
        //$middleware->append(VerifyCsrfToken::class); // Middleware para CSRF
        //$middleware->append(EnsureFrontendRequestsAreStateful::class);
        //$middleware->append(\Illuminate\Session\Middleware\StartSession::class); // Manejo de sesiones
        //$middleware->append(\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class); // Manejo de cookies
        //$middleware->append(\Illuminate\Routing\Middleware\SubstituteBindings::class); // Enlace de rutas
        //$middleware->append(\Illuminate\View\Middleware\ShareErrorsFromSession::class); // Compartir errores de sesión
        //$middleware->append(\App\Http\Middleware\Authenticate::class);

        // //$middleware->append(HandleCors::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();