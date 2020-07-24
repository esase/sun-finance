<?php

namespace SunFinance\Core\ServiceManager;

use Exception;

class ServiceManager
{
    /**
     * @var array
     */
    private $instances = [];

    /**
     * @var array
     */
    private $configs;

    /**
     * ServiceManager constructor.
     *
     * @param array $configs
     */
    public function __construct(array $configs)
    {
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
        if (!isset($this->configs['service_manager'][$name])) {
            throw new Exception('Unknown `' . $name. '`class');
        }

        // call the factory
        $instance = new $this->configs['service_manager'][$name]();
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

