<?php

namespace SunFinance\Core\Config\Factory;

use SunFinance\Core\Config\ConfigService;
use SunFinance\Core\ServiceManager\ServiceManager;

class ConfigServiceFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return ConfigService
     */
    public function __invoke(ServiceManager $serviceManager): ConfigService
    {
        return new ConfigService(
            $serviceManager->getConfigs()
        );
    }
}

