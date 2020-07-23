<?php

namespace SunFinance\Core\Config\Factory;

use SunFinance\Core\Config\Config;
use SunFinance\Core\ServiceManager\ServiceManagerInterface;

class ConfigFactory
{
    /**
     * @param ServiceManagerInterface $serviceManager
     *
     * @return Config
     */
    public function __invoke(ServiceManagerInterface $serviceManager)
    {
        return new Config(
            $serviceManager->getConfigs()
        );
    }
}


