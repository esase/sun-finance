<?php

namespace SunFinance\Modules\Documents\Controllers\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Modules\Documents\Controllers\Documents;
use Exception;
use SunFinance\Modules\Documents\Services;

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
        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);
        /** @var  Services\Documents $service */
        $service = $serviceManager->getInstance(Services\Documents::class);

        return new Documents(
            $request,
            $service
        );
    }
}

