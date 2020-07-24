<?php

namespace SunFinance\Core\Db\Factory;

use SunFinance\Core\Config\ConfigService;
use SunFinance\Core\Db\DbService;
use SunFinance\Core\ServiceManager\ServiceManager;
use Exception;

class DbServiceFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return DbService
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): DbService
    {
        /** @var ConfigService $configService */
        $configService = $serviceManager->getInstance(ConfigService::class);
        $dbParams = $configService->getConfig('db');
        return new DbService(
            ($dbParams['host'] ?? ''),
            ($dbParams['username'] ?? ''),
            ($dbParams['password'] ?? ''),
            ($dbParams['db_name'] ?? '')
        );
    }
}
