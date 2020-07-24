<?php

namespace SunFinance\Core\Http\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\ServiceManager\ServiceManager;

class RequestFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return Request
     */
    public function __invoke(ServiceManager $serviceManager): Request
    {
        return new Request(
            ($_SERVER['REQUEST_URI'] ?? ''),
            ($_SERVER['REQUEST_METHOD'] ?? ''),
            ($_SERVER['SCRIPT_NAME'] ?? '')
        );
    }
}