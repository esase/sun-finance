<?php

namespace SunFinance\Core\Utils\Factory;

use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Core\Utils\FileServiceInterface;
use SunFinance\Core\Utils\LocalFileService;
use Exception;

class FileServiceFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return FileServiceInterface
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): FileServiceInterface
    {
        /** @var  LocalFileService $localFileService */
        $localFileService = $serviceManager->getInstance(LocalFileService::class);

        return $localFileService;
    }
}
