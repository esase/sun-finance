<?php

use SunFinance\Core\Config\Config;
use SunFinance\Core\Router\Router;
use SunFinance\Core\Router\Route;
use SunFinance\Core\ServiceManager\ServiceManager;

require_once __DIR__ . '/vendor/autoload.php';

$serviceManager = new ServiceManager(
    require_once 'service-manager-factories.php',
    require_once 'config.php'
);

/** @var Router $router */
$router = $serviceManager->getInstance(Router::class);
$router->useTrailingSlash(true);

/** @var Config $config */
$config = $serviceManager->getInstance(Config::class);
$routes = $config->getConfig('routes');

// register routes
foreach ($routes as $routeConfig) {
    $router->registerRoute(
        new Route(
            $routeConfig['method'],
            $routeConfig['uri'],
            $routeConfig['controller'],
            $routeConfig['action']
        )
    );
}
$router->handleRequest();
