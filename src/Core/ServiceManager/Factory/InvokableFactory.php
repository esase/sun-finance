<?php

namespace SunFinance\Core\ServiceManager\Factory;

use SunFinance\Core\ServiceManager\ServiceManagerInterface;

class InvokableFactory
{
    /**
     * @param ServiceManagerInterface $serviceManager
     * @param string                  $className
     *
     * @return object
     */
    public function __invoke(
        ServiceManagerInterface $serviceManager,
        string $className
    ) {
        return new $className();
    }
}
