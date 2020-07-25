<?php

namespace SunFinance\Module\Document\Controller\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Document\Controller\Document;
use Exception;
use SunFinance\Module\Document\Service;
use SunFinance\Module\Document\Form;

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
        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);

        /** @var  Service\Document $service */
        $service = $serviceManager->getInstance(Service\Document::class);

        /** @var Form\DocumentBuilder $formBuilder */
        $formBuilder = $serviceManager->getInstance(Form\DocumentBuilder::class);

        return new Document(
            $request,
            $service,
            $formBuilder
        );
    }
}
