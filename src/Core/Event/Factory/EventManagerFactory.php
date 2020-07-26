<?php

namespace SunFinance\Core\Event\Factory;

use SunFinance\Core\Event\EventManager;
use SunFinance\Core\ServiceManager\ServiceManager;
use Exception;

class EventManagerFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return EventManager
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): EventManager
    {
        return new EventManager(
            $serviceManager
        );
    }
}
