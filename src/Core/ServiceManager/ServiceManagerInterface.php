<?php

namespace SunFinance\Core\ServiceManager;

use Exception;

interface ServiceManagerInterface
{
    /**
     * @param string $name
     *
     * @return object
     * @throws Exception
     */
    public function getInstance(string $name);

    /**
     * @return array
     */
    public function getConfigs(): array;
}