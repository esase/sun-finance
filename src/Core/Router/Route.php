<?php

namespace SunFinance\Core\Router;


class Route
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $action;

    /**
     * Route constructor.
     *
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @param string $action
     */
    public function __construct(
        string $method,
        string $uri,
        string $controller,
        string $action
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
        $this->action = $action;
    }
}
