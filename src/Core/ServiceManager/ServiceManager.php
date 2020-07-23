<?php

namespace SunFinance\Core\ServiceManager;

use Exception;

class ServiceManager
    implements ServiceManagerInterface
{
    /**
     * @var array
     */
    private $instances = [];

    /**
     * @var array
     */
    private $factories;

    /**
     * @var array
     */
    private $configs;

    /**
     * ServiceManager constructor.
     *
     * @param array $factories
     * @param array $configs
     */
    public function __construct(
        array $factories,
        array $configs
    ) {
        $this->factories = $factories;
        $this->configs = $configs;
    }

    /**
     * @param string $name
     *
     * @return object
     * @throws Exception
     */
    public function getInstance(string $name)
    {
        // return already created instance
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }
        // create an instance
        if (!isset($this->factories[$name])) {
            throw new Exception('Unknown `' . $name. '`class');
        }

        // call the factory
        $instance = new $this->factories[$name]();
        $this->instances[$name] = $instance($this, $name);

        return $this->instances[$name];
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }
}

