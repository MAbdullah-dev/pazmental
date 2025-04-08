<?php

use App\Http\Middleware\Language;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RestrictSiteAccess;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectAdminIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function () {
            if (str_starts_with(request()->path(), 'admin')) {
                return route('admin.login');
            }

            return route('login');
        });

        $middleware->appendToGroup('web', Language::class);


        $middleware->alias([
            'guest_admin' => RedirectAdminIfAuthenticated::class,
            'site_access' => RestrictSiteAccess::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
