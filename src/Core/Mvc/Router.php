<?php

namespace SunFinance\Core\Mvc;

use SunFinance\Core\Http\Request;
use Exception;

class Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var Route
     */
    private $defaultRoute;

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
            switch ($route->type) {
                case Route::TYPE_LITERAL :
                    if ($this->isMatchedLiteralRoute($uriPath, $route)) {
                        return $route;
                    }
                    break;
                case Route::TYPE_REGEXP :
                    if ($this->isMatchedRegexpRoute($uriPath, $route)) {
                        return $route;
                    }
                    break;
            }
        }

        // return a default route
        if ($this->defaultRoute) {
            return $this->defaultRoute;
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
        return $uriPath === $route->uri
            && $route->method === $this->request->getMethod();
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
        if ($route->method === $this->request->getMethod()) {
            $matches = [];
            preg_match($route->uri, $uriPath, $matches);
            if ($matches) {
                $uriParams = [];
                // extract uri params
                foreach ($route->uriParams as $uriParam) {
                    if (isset($matches[$uriParam])) {
                        $uriParams[$uriParam] = $matches[$uriParam];
                    }
                }
                $this->request->setUriParams($uriParams);
                return true;
            }
        }
        return false;
    }
}
