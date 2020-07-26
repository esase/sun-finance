<?php

use SunFinance\Core\Event;
use SunFinance\Core\Http;
use SunFinance\Core\Mvc;
use SunFinance\Module;
use SunFinance\Core\Config;
use SunFinance\Core\ServiceManager\ServiceManager;

require_once __DIR__ . '/vendor/autoload.php';

try {
    // init the service manager
    $serviceManager = new ServiceManager(
        require_once 'config.php'
    );

    /** @var Config\ConfigService $configService */
    $configService = $serviceManager->getInstance(Config\ConfigService::class);

    // init the event manager
    /** @var  Event\EventManager $eventManager */
    $eventManager = $serviceManager->getInstance(Event\EventManager::class);
    foreach ($configService->getConfig('event') as $eventName => $subscribers) {
        foreach ($subscribers as $className => $action) {
            $eventManager->subscribe(
                $eventName,
                $className,
                $action
            );
        }
    }

    // init the router
    /** @var  Mvc\Router $router */
    $router = $serviceManager->getInstance(Mvc\Router::class);
    $router->setDefaultRoute(
        new Mvc\Route(
            Module\Base\Controller\NotFound::class,
            [
                Http\Request::METHOD_ALL => 'index'
            ]
        )
    );

    // register routes
    foreach ($configService->getConfig('routes') as $route) {
        $router->registerRoute(
            new Mvc\Route(
                $route['controller'],
                $route['action_list'],
                $route['method_list'],
                $route['uri'],
                $route['uri_params'] ?? [],
                $route['type'] ?? Mvc\Route::TYPE_LITERAL
            )
        );
    }

    $route = $router->getMatchedRoute();

    // create the matched controller
    $controller = $serviceManager->getInstance($route->getController());

    /** @var Http\AbstractResponse $response */
    $response = $serviceManager->getInstance(Http\AbstractResponse::class);

    // process the response
    try {
        $eventManager->trigger(Event\Event::BEFORE_CALLING_CONTROLLER, [
            'controller' => $route->getController(),
            'action' => $route->getAction(),
            'params' => $route->getUriParams(),
        ]);
        $result = $controller->{$route->getAction()}();
        $eventManager->trigger(Event\Event::AFTER_CALLING_CONTROLLER, [
            'controller' => $route->getController(),
            'action' => $route->getAction(),
            'result' => $result
        ]);
        $response->setResponse($result);
    }
    catch (Http\Exception\BaseException $e) {
        $response->setResponseCode($e->getCode());
        if  ($e->getMessage()) {
            $response->setResponse($e->getMessage());
        }
    }
    $response->displayResponse();
}
catch (Throwable $e) {
    if (getenv('APPLICATION_ENV') === 'dev') {
        throw $e;
    }
}
