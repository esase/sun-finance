<?php

namespace SunFinance\Core\Utils\Factory;

use SunFinance\Core\Config\ConfigService;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Core\Utils\LocalFileService;
use Exception;

class LocalFileServiceFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return LocalFileService
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): LocalFileService
    {
        /** @var  ConfigService $configService */
        $configService = $serviceManager->getInstance(ConfigService::class);

        return new LocalFileService(
            $configService
        );
    }
}
