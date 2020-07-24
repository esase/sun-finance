<?php

namespace SunFinance\Modules\Documents\Controllers\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;
use SunFinance\Modules\Documents\Controllers\Documents;
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
        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);
        return new Documents(
            $request
        );
    }
}

