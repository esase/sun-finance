<?php

namespace SunFinance\Module\Document\Form\Factory;

use SunFinance\Core\Form\Form;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Document\Form\DocumentBuilder;
use Exception;

class DocumentBuilderFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return DocumentBuilder
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): DocumentBuilder
    {
        return new DocumentBuilder(
            new Form()
        );
    }
}
