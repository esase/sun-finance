<?php

namespace SunFinance\Core\Mvc;

class Route
{
    const TYPE_LITERAL = 'literal';
    const TYPE_REGEXP = 'regexp';

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var array
     */
    protected $actionList;

    /**
     * @var string|array
     */
    protected $methodList;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $uriParams = [];

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $action;

    /**
     * Route constructor.
     *
     * @param string $controller
     * @param array  $actionList
     * @param array  $methodList
     * @param string $uri
     * @param array  $uriParams
     * @param string $type
     */
    public function __construct(
        string $controller,
        array $actionList,
        array $methodList = [],
        string $uri = null,
        array $uriParams = [],
        string $type = self::TYPE_LITERAL
    ) {
        $this->controller = $controller;
        $this->actionList = $actionList;
        $this->methodList = $methodList;
        $this->uri = $uri;
        $this->uriParams = $uriParams;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return array
     */
    public function getActionList(): array
    {
        return $this->actionList;
    }

    /**
     * @return array
     */
    public function getMethodList(): array
    {
        return $this->methodList;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }
}
