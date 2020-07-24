<?php

namespace SunFinance\Core\Config;

use Exception;

class ConfigService
{
    /**
     * @var array
     */
    private $configs;

    /**
     * Config constructor.
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
     * @return mixed
     * @throws Exception
     */
    public function getConfig(string $name)
    {
        if (isset($this->configs[$name])) {
            return $this->configs[$name];
        }

        throw new Exception('Unknown config `' . $name . '`');
    }
}
