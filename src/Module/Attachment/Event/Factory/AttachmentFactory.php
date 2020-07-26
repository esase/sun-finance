<?php

namespace SunFinance\Module\Attachment\Event\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Attachment\Event\Attachment;
use SunFinance\Module\Attachment\Service;
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
        /** @var  Service\Attachment $service */
        $service = $serviceManager->getInstance(Service\Attachment::class);

        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);

        return new Attachment(
            $service,
            $request
        );
    }
}
