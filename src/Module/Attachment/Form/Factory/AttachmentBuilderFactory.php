<?php

namespace SunFinance\Module\Attachment\Form\Factory;

use SunFinance\Core\Form\Form;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Module\Attachment\Form\AttachmentBuilder;
use Exception;

class AttachmentBuilderFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return AttachmentBuilder
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): AttachmentBuilder
    {
        return new AttachmentBuilder(
            new Form()
        );
    }
}
