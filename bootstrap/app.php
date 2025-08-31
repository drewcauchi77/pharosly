<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request): Response {
            if ($response->getStatusCode() === 419)
            {
                return redirect()->back()->with('notification', [
                    'isError' => true,
                    'title' => 'Page Expired',
                    'description' => 'Your current page has expired. Please refresh the page.',
                ]);
            }
            else if ($response->getStatusCode() === 404)
            {
                // Redirect 404
            }
            else if ($response->getStatusCode() === 403)
            {
                return redirect()->back()->with('notification', [
                    'isError' => true,
                    'title' => 'Forbidden',
                    'description' => 'You are not allowed to access this page or do this action.',
                ]);
            }
            else
            {
                return redirect()->back()->with('notification', [
                    'isError' => true,
                    'title' => 'Unexpected Error',
                    'description' => 'An unexpected error has occurred - please try again later.',
                ]);
            }

            return $response;
        });
    })->create();
