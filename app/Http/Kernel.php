<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        // \App\Http\Middleware\HttpsProtocol::class,
        // \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'redirectsave'  => \App\Http\Middleware\RedirectSave::class,
        'customer'      => \App\Http\Middleware\CustomerAndAccessor::class,
        'auth'          => \App\Http\Middleware\Authenticate::class,
        'staff'         => \App\Http\Middleware\StaffAndAccessor::class,
        'manager'       => \App\Http\Middleware\ManagerAndAccessor::class,
        'admin'         => \App\Http\Middleware\AdminAuth::class,
        'passwordneeded'=> \App\Http\Middleware\PasswordNeeded::class,
        'auth.basic'    => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'         => \App\Http\Middleware\RedirectIfAuthenticated::class,
    ];
}
