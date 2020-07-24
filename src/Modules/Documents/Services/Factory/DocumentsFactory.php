<?php

namespace SunFinance\Modules\Documents\Services\Factory;

use SunFinance\Core\Db\DbService;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Modules\Documents\Services\Documents;
use Exception;

class DocumentsFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return Documents
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): Documents
    {
        /** @var  DbService $dbService */
        $dbService = $serviceManager->getInstance(DbService::class);
        return new Documents(
            $dbService
        );
    }
}

