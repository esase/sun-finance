<?php

namespace SunFinance\Core\ServiceManager\Factory;


use SunFinance\Core\ServiceManager\ServiceManager;

class InvokableFactory
{
    /**
     * @param ServiceManager $serviceManager
     * @param string                  $className
     *
     * @return object
     */
    public function __invoke(
        ServiceManager $serviceManager,
        string $className
    ) {
        return new $className();
    }
}
