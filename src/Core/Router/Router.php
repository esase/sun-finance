<?php

namespace SunFinance\Core\Router;

use Exception;
use SunFinance\Core\ServiceManager\ServiceManagerInterface;

class Router
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const BASE_SCRIPT_NAME = '/index.php';

    /**
     * @var ServiceManagerInterface
     */
    private $serviceManager;

    /**
     * @var array
     */
    private $server;

    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var string
     */
    private $defaultController;

    /**
     * @var string
     */
    private $defaultAction;

    /**
     * Router constructor.
     *
     * @param ServiceManagerInterface $serviceManager
     * @param array                   $server
     * @param string                  $defaultController
     * @param string                  $defaultAction
     */
    public function __construct(
        ServiceManagerInterface $serviceManager,
        array $server,
        string $defaultController,
        string $defaultAction
    ) {
        $this->serviceManager = $serviceManager;
        $this->server = $server;
        $this->defaultController = $defaultController;
        $this->defaultAction = $defaultAction;
    }

    /**
     * @param Route $route
     */
    public function registerRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @throws Exception
     */
    public function handleRequest()
    {
        $uri = $this->getUri();
        $method = $this->getMethod();

        $controllerName = null;
        $action = null;

        // find a matched uri
        foreach ($this->routes as $route) {
            if(strtolower($route->uri) === $uri
                    && $method === $route->method) {

                $controllerName = $route->controller;
                $action = $route->action;
                break;
            }
        }

        // process default action
        if (!$controllerName && !$action) {
            $controller = $this->
                serviceManager->getInstance($this->defaultController);
            $controller->{$this->defaultAction}();
            return;
        }

        $controller = $this->
            serviceManager->getInstance($controllerName);
        $controller->{$action}();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? '';
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        // remove the base script name from the requested uri (we may be worked from a sub dir)
        $scriptName = $this->server['SCRIPT_NAME'] ?? '';
        $scriptPath = str_replace(
            self::BASE_SCRIPT_NAME,
            '',
            $scriptName
        );
        $uri = $this->server['REQUEST_URI'] ?? '';
        return strtolower(str_replace($scriptPath, '', $uri));
    }

}
