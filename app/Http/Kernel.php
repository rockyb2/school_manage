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
        // Ajoutez ici les middlewares globaux si nécessaire
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // Ajoutez ici les middlewares pour le groupe web
        ],

        'api' => [
            // Ajoutez ici les middlewares pour le groupe api
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Ajoutez ici les middlewares de route
        'ensure.enseignant.authenticated' => \App\Http\Middleware\EnsureEnseignantIsAuthenticated::class,
    ];
}
