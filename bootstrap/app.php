<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();
/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);
$app->singleton('filesystem', function ($app) {
    return $app->loadComponent(
        'filesystems',
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        'filesystem'
    );
});

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
    App\Http\Middleware\JsonRequestMiddleware::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

// Route List in Terminal
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);

$app->register(Fruitcake\Cors\CorsServiceProvider::class);
$app->register(Appzcoder\LumenRoutesList\RoutesCommandServiceProvider::class);

// Register Service Providers
$app->register(BeyondCode\ErdGenerator\ErdGeneratorServiceProvider::class);
$app->configure('erd-generator');


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

/**
 * Api Routes
 */

$app->router->group([
        'prefix'    => 'api/v1',
        'namespace' => 'App\Http\Controllers\V1',
    ], function ($router) {
        require __DIR__.'/../routes/api/v1/main.php';
    }
);
/**
 * Portal Route
 */
$app->router->group([
        'prefix'        => 'api/v1/portal',
        'namespace'     => 'App\Http\Controllers\V1',
        'middleware'    => 'auth:chival',
    ], function ($router) {
        require __DIR__.'/../routes/api/v1/portal/portal.php';
    }
);
$app->router->group([
        'prefix'        => 'api/v1/portal/companies',
        'namespace'     => 'App\Http\Controllers\V1',
        'middleware'    => 'auth:chival',
    ], function ($router) {
        require __DIR__.'/../routes/api/v1/portal/company.php';
    }
);
$app->router->group([
        'prefix'    => 'api/v1/core',
        'namespace' => 'App\Http\Controllers\V1\Core',
        'as'        => 'core',
    ], function ($router) {
        require __DIR__.'/../routes/api/v1/core.php';
    }
);
/**
 * Clients Route
 */
$app->router->group([
        'prefix'        => 'api/v1/client',
        'namespace'     => 'App\Http\Controllers\V1\Client',
        'middleware'    => 'auth:company',
    ], function ($router) {
    require __DIR__.'/../routes/api/v1/client/portal.php';
});
$app->router->group([
        'prefix'        => 'api/v1/client/travels',
        'namespace'     => 'App\Http\Controllers\V1\Client\Travel',
        'middleware'    => 'auth:company',
    ], function ($router) {
    require __DIR__.'/../routes/api/v1/client/travel.php';
});
$app->router->group([
        'prefix'        => 'api/v1/client/core',
        'namespace'     => 'App\Http\Controllers\V1\Core',
        'middleware'    => 'auth:company',
    ], function ($router) {
    require __DIR__.'/../routes/api/v1/client/core.php';
});

/**
 * Web Routes
 */
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});
// $app->router->group([
//     'namespace' => 'App\Http\Controllers',
// ], function ($router) {
//     require __DIR__.'/../routes/web.php';
// });

return $app;
