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
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'managePerm' => \App\Http\Middleware\ManagePerm::class,
        'loginCheckV1' => \App\Http\Middleware\login\v1\checkAuthentication::class,
        'loginApicheckV1' => \App\Http\Middleware\login\v1\checkApiKey::class,
        'apiHitLogV1' => \App\Http\Middleware\login\v1\checkApiHitLog::class,
        'loginCheckV2' => \App\Http\Middleware\login\v2\checkAuthentication::class,
        'loginApicheckV2' => \App\Http\Middleware\login\v2\checkApiKey::class,
    ];
}
