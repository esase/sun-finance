<?php

namespace SunFinance\Core\File\Factory;

use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Core\File\FileServiceInterface;
use SunFinance\Core\File\LocalFileService;
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
