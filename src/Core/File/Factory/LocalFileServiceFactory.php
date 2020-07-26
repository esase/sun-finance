<?php

namespace SunFinance\Core\File\Factory;

use SunFinance\Core\Config\ConfigService;
use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Core\File\LocalFileService;
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

        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);

        return new LocalFileService(
            $configService,
            $request
        );
    }
}
