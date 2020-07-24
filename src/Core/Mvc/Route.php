<?php

namespace SunFinance\Core\Mvc;

use SunFinance\Core\Http\Request;

class Route
{
    const TYPE_LITERAL = 'literal';
    const TYPE_REGEXP = 'regexp';

    /**
     * @var string
     */
    public $controller;

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $uri;

    /**
     * @var array
     */
    public $uriParams = [];

    /**
     * @var string
     */
    public $type;

    /**
     * Route constructor.
     *
     * @param string $controller
     * @param string $action
     * @param string $method
     * @param string $uri
     * @param array  $uriParams
     * @param string $type
     */
    public function __construct(
        string $controller,
        string $action,
        string $method = Request::METHOD_GET,
        string $uri = null,
        array $uriParams = [],
        string $type = self::TYPE_LITERAL
    ) {
        $this->controller = $controller;
        $this->action = $action;
        $this->method = $method;
        $this->uri = $uri;
        $this->uriParams = $uriParams;
        $this->type = $type;
    }
}
