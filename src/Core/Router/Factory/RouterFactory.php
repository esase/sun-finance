<?php

namespace SunFinance\Core\Router\Factory;

use SunFinance\Core\Router\Router;
use SunFinance\Core\ServiceManager\ServiceManagerInterface;
use SunFinance\Modules\Base\Controllers\NotFound;

class RouterFactory
{
    /**
     * @param ServiceManagerInterface $serviceManager
     *
     * @return Router
     */
    public function __invoke(ServiceManagerInterface $serviceManager)
    {
        return new Router(
            $serviceManager,
            $_SERVER,
            NotFound::class,
            'index'
        );
    }
}
