<?php

namespace SunFinance\Core\Mvc;

use SunFinance\Core\Http\Request;
use Exception;

class Router
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Route[]
     */
    protected $routes = [];

    /**
     * @var Route
     */
    protected $defaultRoute;

    /**
     * Router constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Route $route
     */
    public function setDefaultRoute(Route $route)
    {
        $this->defaultRoute = $route;
    }

    /**
     * @param Route $route
     */
    public function registerRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @return Route
     * @throws Exception
     */
    public function getMatchedRoute(): Route
    {
        $uriPath = $this->request->getUriPath();

        // find a matched route
        foreach ($this->routes as $route) {
            if (in_array($this->request->getMethod(), $route->getMethodList())
                || in_array(Request::METHOD_ALL, $route->getMethodList())) {
                switch ($route->getType()) {
                    case Route::TYPE_LITERAL :
                        if ($this->isMatchedLiteralRoute($uriPath, $route)) {
                            return $this->initControllerAction($route);
                        }
                        break;

                    case Route::TYPE_REGEXP :
                        if ($this->isMatchedRegexpRoute($uriPath, $route)) {
                            return $this->initControllerAction($route);
                        }
                        break;
                }
            }
        }

        // return a default route
        if ($this->defaultRoute) {
            return $this->initControllerAction($this->defaultRoute);
        }

        throw new Exception('Cannot match any routes');
    }

    /**
     * @param string $uriPath
     * @param Route  $route
     *
     * @return bool
     */
    protected function isMatchedLiteralRoute(
        string $uriPath,
        Route $route
    ): bool {
        return $uriPath === $route->getUri();
    }

    /**
     * @param string $uriPath
     * @param Route  $route
     *
     * @return bool
     */
    protected function isMatchedRegexpRoute(
        string $uriPath,
        Route $route
    ): bool {
        $matches = [];

        // check if the uri is matched by a regexp
        preg_match($route->getUri(), $uriPath, $matches);
        if ($matches) {
            $uriParams = [];

            // extract uri params
            foreach ($route->getUriParams() as $uriParam) {
                if (isset($matches[$uriParam])) {
                    $uriParams[$uriParam] = $matches[$uriParam];
                }
            }
            // add the found uri params to the request
            $this->request->setUriParams($uriParams);

            return true;
        }

        return false;
    }

    /**
     * @param Route $route
     *
     * @return Route
     * @throws Exception
     */
    protected function initControllerAction(Route $route): Route
    {
        $actions = $route->getActionList();

        // select a controller action related with the http method
        $action = $actions[$this->request->getMethod()] ??
            $actions[Request::METHOD_ALL] ?? '';

        if (!$action) {
            throw new Exception('Cannot find a controller action');
        }

        $route->setAction($action);
        return $route;
    }
}
