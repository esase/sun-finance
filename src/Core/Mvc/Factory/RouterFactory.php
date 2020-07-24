<?php

namespace SunFinance\Core\Mvc\Factory;

use SunFinance\Core\Http\Request;
use SunFinance\Core\Mvc\Router;
use SunFinance\Core\ServiceManager\ServiceManager;
use Exception;

class RouterFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return Router
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): Router
    {
        /** @var  Request $request */
        $request = $serviceManager->getInstance(Request::class);
        return new Router($request);
    }
}
