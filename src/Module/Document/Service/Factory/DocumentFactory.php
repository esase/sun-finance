<?php

namespace SunFinance\Module\Document\Service\Factory;

use SunFinance\Core\Db\DbService;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Document\Service\Document;
use Exception;

class DocumentFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return Document
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): Document
    {
        /** @var  DbService $dbService */
        $dbService = $serviceManager->getInstance(DbService::class);
        return new Document(
            $dbService
        );
    }
}
