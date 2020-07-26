<?php

namespace SunFinance\Module\Attachment\Service\Factory;

use SunFinance\Core\Db\DbService;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Attachment\Service\Attachment;
use Exception;

class AttachmentFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return Attachment
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): Attachment
    {
        /** @var  DbService $dbService */
        $dbService = $serviceManager->getInstance(DbService::class);
        return new Attachment(
            $dbService
        );
    }
}
