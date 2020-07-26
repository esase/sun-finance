<?php

namespace SunFinance\Module\Attachment\Controller\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Attachment\Controller\Attachment;
use SunFinance\Module\Attachment\Service;
use SunFinance\Module\Attachment\Form;
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
        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);

        /** @var  Service\Attachment $service */
        $service = $serviceManager->getInstance(Service\Attachment::class);

        /** @var Form\AttachmentBuilder $formBuilder */
        $formBuilder = $serviceManager->getInstance(Form\AttachmentBuilder::class);

        return new Attachment(
            $request,
            $service,
            $formBuilder
        );
    }
}
