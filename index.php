<?php

use SunFinance\Core\Mvc;
use SunFinance\Modules;
use SunFinance\Core\Config;
use SunFinance\Core\ServiceManager\ServiceManager;

require_once __DIR__ . '/vendor/autoload.php';

try {
    // init the service manager
    $serviceManager = new ServiceManager(
        require_once 'config.php'
    );

    // init the router
    /** @var  Mvc\Router $router */
    $router = $serviceManager->getInstance(Mvc\Router::class);
    $router->setDefaultRoute(
        new Mvc\Route(
            Modules\Base\Controllers\NotFound::class,
            'index'
        )
    );

    /** @var Config\ConfigService $configService */
    $configService = $serviceManager->getInstance(Config\ConfigService::class);

    // register routes
    foreach ($configService->getConfig('routes') as $route) {
        $router->registerRoute(
            new Mvc\Route(
                $route['controller'],
                $route['action'],
                $route['method'],
                $route['uri'],
                $route['uri_params'] ?? [],
                $route['type'] ?? Mvc\Route::TYPE_LITERAL
            )
        );
    }

    $route = $router->getMatchedRoute();

    // call the matched controller
    $controller = $serviceManager->getInstance($route->controller);
    $controller->{$route->action}();
}
catch (Throwable $e) {
    if (getenv('APPLICATION_ENV') === 'dev') {
        throw $e;
    }
}

